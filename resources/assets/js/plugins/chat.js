function Chat() {
    var
        _this = this;

    _this.init = function(){

        app.socket.on('message', function(msg) {
            _this.newMessage(msg.data);
        });
    };

    _this.scrollBottom = function($container){
        var $messsages = $container;

        if ( ! $container.hasClass('messages'))
            $messsages = $('.messages', $container);

        if ( ! $messsages.length)
            return;

        $messsages.scrollTop( $messsages[0].scrollHeight - $messsages[0].clientHeight);
    };

    _this.keyDown = function(e, input){
        if (e.keyCode != 13)
            return;

        $form = $(input).closest('form');

        _this.send($form);
    };

    _this.send = function (form) {
        var $form = $(form);

        if ( ! $('input[name="message"]', $form).val() )
            return false;

        $.ajax({
            type: 'POST',
            dataType: "json",
            data: $(form).serialize(),
            url: $(form).attr('action'),
            success: function (res) {
                if (res.errors) {}
            }
        });

        $('input[name="message"]', $form).val('');

        return false;
    };

    _this.isOpenedChat = function(chat_id) {
        return $('.conversation[data-chatid="'+chat_id+'"]:visible').length;
    };

    _this.loadChat = function(url, $container) {
        $.ajax({
            type: 'GET',
            dataType: 'html',
            url:  url,
            success: function(response) {
                $container.append( response );

                _this.scrollBottom($container);


            }
        });
    };

    _this.getMessages = function(chatId, url) {

        var _conversations = $('.conversation[data-chatid="'+chatId+'"]:visible .messages');

        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: url,
            timeout: 60000,
            beforeSend: function() {
                $.each(_conversations, function(index, _conversation) {
                    $container = $( _conversation );
                    loader.add( $container );
                });
            },
            success: function(response) {
                if (response.status == 1) {
                    if (response.data.length > 0) {
                        $.each(_conversations, function (index, _conversation) {
                            var _height = _conversation.scrollHeight;

                            $.each(response.data, function (key, value) {
                                _this.preppendMessage(value, _conversation);
                            });

                            $(_conversation).scrollTop( _conversation.scrollHeight - _height);
                        });
                    }
                    if (response.next_page_url) {
                        $.each(_conversations, function (index, _conversation) {
                            $( _conversation ).prepend('<li data-next="'+response.next_page_url+'"></li>');
                        });
                    }
                }
            },
            complete: function() {
                $.each(_conversations, function(index, _conversation) {
                    $container = $( _conversation );
                    loader.remove( $container );
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
        });


    };

    _this.openChatModal = function(url) {
        $.ajax({
            type: 'GET',
            dataType: 'html',
            url:  url,

            success: function(response) {
                var $conversation = $('#conversation');

                $conversation.html( response );

                _this.scrollBottom($conversation);
            }
        });
    };

    _this.newMessage = function(message) {
        if (_this.isOpenedChat(message.chat_id)) {
            var _conversations = $('.conversation[data-chatid="'+message.chat_id+'"]:visible .messages');

            $.each(_conversations, function(index, _conversation){
                _this.appendMessage(message, _conversation);
            });
        } else {
            _this.loadChat(message.chat_url, $('#conversations'));
        }
    };

    _this.preppendMessage = function(message, $container) {
        $container = $( $container );

        $container.prepend(_this.messageHtml(message));
    };

    _this.appendMessage = function(message, $container) {
        $container = $( $container );

        $container.append(_this.messageHtml(message));

        _this.scrollBottom($container);
    };

    _this.messageHtml = function(message) {
        var html = $('<li class="message"></li>');
        if (message.chattable_id == app.user_id)
            html.addClass('me');

        html.append( $('<span class="text">' + message.content + '</span>') );
        html.append( $('<span class="author">' + message.sender_name + '</span>') );

        return html;
    };

    _this.close = function(elem) {
        $(elem).closest('.conversation').remove();
    }
};

$("body").on("click", ".chat_device", function(e){
    e.preventDefault();
    app.chat.loadChat($(this).data('url'), $('#conversations'));
});

