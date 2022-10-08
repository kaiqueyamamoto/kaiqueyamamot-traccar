function DeviceMedia() {
    var
        _this = this;

    _this.resetCameraWindow = function () {
        $('#camera_photos #ajax-photos').html('');
        $('#camera_photos #imgContainer').html('');
        $('#camera_photos .alert-danger.main-alert').html('').css('display', 'none');
        $('#camera_photos .alert-success').html('').css('display', 'none');
        $( "#mapForPhoto" ).html('');
    };

    _this.getImages = function (deviceId, container) {
        dd('devices.getImages');

        if (!app.devices.get(deviceId))
            return;

        _this.resetCameraWindow();

        var $container = $(container);
        $.ajax({
            type: 'GET',
            dataType: 'html',
            url: app.urls.deviceImages + deviceId,
            timeout: 60000,
            beforeSend: function () {
                loader.add($container);
                $('tr[data-deviceContainer]').removeClass('active');
            },
            success: function (response) {
                $container.html(response);
                initComponents($container);
            },
            complete: function () {
                $('tr[data-deviceContainer="' + deviceId + '"]').addClass('active');
                loader.remove($container);
            }
        });

        var sendCommands = new Commands();

        $('#requestPhoto input[name="device_id"]').val(deviceId);

        sendCommands.getDeviceCommands(
            deviceId,
            function () {
                $('#takePhoto').attr('disabled', 'disabled');
            },
            function () {
                sendCommands.buildAttributes('requestPhoto', '#requestPhoto .attributes');

                if (sendCommands.getCommand('requestPhoto'))
                    $('#takePhoto').removeAttr('disabled');
            }
        );
    };

    _this.loadImage = function (deviceId, fileName, container) {
        var $container = $(container);
        $.ajax({
            type: 'GET',
            dataType: 'html',
            url: app.urls.deviceImage + deviceId + '/' + fileName,
            timeout: 60000,
            beforeSend: function () {
                loader.add($container);
                $('tr[data-imageContainer]').removeClass('active');
            },
            success: function (response) {
                $container.html(response);
                $('tr[data-imageContainer="' + fileName + '"]').addClass('active');
            },
            complete: function () {
                loader.remove($container);
            }
        });
    };

    _this.deleteImage = function (deviceId, fileName, container) {
        var $container = $(container);
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: app.urls.deleteImage + deviceId + '/' + fileName,
            timeout: 60000,
            beforeSend: function () {
                loader.add($container);
                $('tr[data-imageContainer]').removeClass('active');
            },
            success: function (response) {
                if (response.success == true) {
                    _this.getImages(deviceId, container);
                }
            },
            complete: function () {
                loader.remove($container);
            }
        });
    };
}
