!function(e){"object"==typeof exports&&"object"==typeof module?e(require("../../lib/codemirror")):"function"==typeof define&&define.amd?define(["../../lib/codemirror"],e):e(CodeMirror)}(function(y){var r={pairs:"()[]{}''\"\"",triples:"",explode:"[]{}"},S=y.Pos;function O(e,t){return"pairs"==t&&"string"==typeof e?e:"object"==typeof e&&null!=e[t]?e[t]:r[t]}y.defineOption("autoCloseBrackets",!1,function(e,t,r){r&&r!=y.Init&&(e.removeKeyMap(i),e.state.closeBrackets=null),t&&(n(O(t,"pairs")),e.state.closeBrackets=t,e.addKeyMap(i))});var i={Backspace:function(e){var t=R(e);if(!t||e.getOption("disableInput"))return y.Pass;for(var r=O(t,"pairs"),n=e.listSelections(),i=0;i<n.length;i++){if(!n[i].empty())return y.Pass;var a=s(e,n[i].head);if(!a||r.indexOf(a)%2!=0)return y.Pass}for(var i=n.length-1;0<=i;i--){var o=n[i].head;e.replaceRange("",S(o.line,o.ch-1),S(o.line,o.ch+1),"+delete")}},Enter:function(n){var e=R(n),t=e&&O(e,"explode");if(!t||n.getOption("disableInput"))return y.Pass;for(var i=n.listSelections(),r=0;r<i.length;r++){if(!i[r].empty())return y.Pass;var a=s(n,i[r].head);if(!a||t.indexOf(a)%2!=0)return y.Pass}n.operation(function(){var e=n.lineSeparator()||"\n";n.replaceSelection(e+e,null),n.execCommand("goCharLeft"),i=n.listSelections();for(var t=0;t<i.length;t++){var r=i[t].head.line;n.indentLine(r,null,!0),n.indentLine(r+1,null,!0)}})}};function n(e){for(var t=0;t<e.length;t++){var r=e.charAt(t),n="'"+r+"'";i[n]||(i[n]=a(r))}}function a(t){return function(e){return function(i,e){var t=R(i);if(!t||i.getOption("disableInput"))return y.Pass;var r=O(t,"pairs"),n=r.indexOf(e);if(-1==n)return y.Pass;for(var a,o=O(t,"triples"),s=r.charAt(n+1)==e,l=i.listSelections(),c=n%2==0,f=0;f<l.length;f++){var h,d=l[f],u=d.head,g=i.getRange(u,S(u.line,u.ch+1));if(c&&!d.empty())h="surround";else if(!s&&c||g!=e)if(s&&1<u.ch&&0<=o.indexOf(e)&&i.getRange(S(u.line,u.ch-2),u)==e+e){if(2<u.ch&&/\bstring/.test(i.getTokenTypeAt(S(u.line,u.ch-2))))return y.Pass;h="addFour"}else if(s){var p=0==u.ch?" ":i.getRange(S(u.line,u.ch-1),u);if(y.isWordChar(g)||p==e||y.isWordChar(p))return y.Pass;h="both"}else{if(!c||!(i.getLine(u.line).length==u.ch||(v=g,void 0,-1<(m=r.lastIndexOf(v))&&m%2==1)||/\s/.test(g)))return y.Pass;h="both"}else h=!s||(C=u,void 0,x=(b=i).getTokenAt(S(C.line,C.ch+1)),!/\bstring/.test(x.type)||x.start!=C.ch||0!=C.ch&&/\bstring/.test(b.getTokenTypeAt(C)))?0<=o.indexOf(e)&&i.getRange(u,S(u.line,u.ch+3))==e+e+e?"skipThree":"skip":"both";if(a){if(a!=h)return y.Pass}else a=h}var v,m;var b,C,x;var P=n%2?r.charAt(n-1):e,k=n%2?e:r.charAt(n+1);i.operation(function(){if("skip"==a)i.execCommand("goCharRight");else if("skipThree"==a)for(var e=0;e<3;e++)i.execCommand("goCharRight");else if("surround"==a){for(var t=i.getSelections(),e=0;e<t.length;e++)t[e]=P+t[e]+k;i.replaceSelections(t,"around"),t=i.listSelections().slice();for(var e=0;e<t.length;e++)t[e]=(r=t[e],void 0,n=0<y.cmpPos(r.anchor,r.head),{anchor:new S(r.anchor.line,r.anchor.ch+(n?-1:1)),head:new S(r.head.line,r.head.ch+(n?1:-1))});i.setSelections(t)}else"both"==a?(i.replaceSelection(P+k,null),i.triggerElectric(P+k),i.execCommand("goCharLeft")):"addFour"==a&&(i.replaceSelection(P+P+P+P,"before"),i.execCommand("goCharRight"));var r,n})}(e,t)}}function R(e){var t=e.state.closeBrackets;return!t||t.override?t:e.getModeAt(e.getCursor()).closeBrackets||t}function s(e,t){var r=e.getRange(S(t.line,t.ch-1),S(t.line,t.ch+1));return 2==r.length?r:null}n(r.pairs+"`")});