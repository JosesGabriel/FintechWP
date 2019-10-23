<div class="dbuttonenter" style="margin-right: 1px;">
    <a href="javascript:void(0)" id="share__btn" data-toggle="modal" data-target="#share" class="fancybox-inline enter-trade-btn" style="font-weight: 400;">Share</a>
</div>

<div class="modal fade share-modal" id="share" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header share-modal-header" >
                <div class="share--modal__socialWrapper">
                    <span>Share on: </span>
                    <button class="btn share__btn--social" onclick="shareOnFB();"><i class="fab fa-facebook-f"></i></button>
                    <button class="btn share__btn--social"><i class="fab fa-twitter"></i></button>
                    <button type="button" class="close" data-dismiss="modal" style="color: white;">&times;</button>
                </div>
                <div id="share-modal-image-container" class="share-modal-image-container">  
                    <div id="preloader">
                        <div id="status">&nbsp;</div>
                        <div id="status_txt"></div>
                    </div>
                </div>
            </div>
            <div class="modal-body share-modal-body">
                <textarea rows="3" placeholder="Say something about this..."></textarea>
                <button type="button" class="arbitrage-button arbitrage-button--primary" style="float: right;">Post</button>
            </div>
        </div>
        
    </div>
</div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=407039123333666&version=v2.0&message=This%20is%20awesome!";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script type="text/javascript">
            function shareOnFB() {
                var imageData = $('#image-to-share').attr('src');
                var mimeType = base64MimeType(imageData);
                var blob = dataURItoBlob(imageData,mimeType);
                FB.getLoginStatus(function (response) {
                    console.log(response);
                    if (response.status === "connected") {
                        postImageToFacebook(response.authResponse.accessToken, "Canvas to Facebook/Twitter", "image/png", blob, window.location.href);
                    } else if (response.status === "not_authorized") {
                        FB.login(function (response) {
                            postImageToFacebook(response.authResponse.accessToken, "Canvas to Facebook/Twitter", "image/png", blob, window.location.href);
                        }, {scope: "publish_actions"});
                    } else {
                        FB.login(function (response) {
                            postImageToFacebook(response.authResponse.accessToken, "Canvas to Facebook/Twitter", "image/png", blob, window.location.href);
                        }, {scope: "publish_actions"});
                    }
                });
            }
            function postImageToFacebook(token, filename, mimeType, imageData, message) {

                var fd = new FormData();
                fd.append("access_token", token);
                fd.append("source", blob);
                fd.append("no_story", true);

                // Upload image to facebook without story(post to feed)
                $.ajax({
                    url: "https://graph.facebook.com/me/photos?access_token=" + token,
                    type: "POST",
                    data: fd,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        console.log("success: ", data);

                        // Get image source url
                        FB.api(
                            "/" + data.id + "?fields=images",
                            function (response) {
                                if (response && !response.error) {
                                    //console.log(response.images[0].source);

                                    // Create facebook post using image
                                    FB.api(
                                        "/me/feed",
                                        "POST",
                                        {
                                            "message": "",
                                            "picture": response.images[0].source,
                                            "link": window.location.href,
                                            "name": 'Look at the cute panda!',
                                            "description": message,
                                            "privacy": {
                                                value: 'SELF'
                                            }
                                        },
                                        function (response) {
                                            if (response && !response.error) {
                                                /* handle the result */
                                                console.log("Posted story to facebook");
                                                console.log(response);
                                            }
                                        }
                                    );
                                }
                            }
                        );
                    },
                    error: function (shr, status, data) {
                        console.log("error " + data + " Status " + JSON.stringify(shr));
                    },
                    complete: function (data) {
                        //console.log('Post to facebook Complete');
                    }
                });
            }
            function dataURItoBlob(dataURI,mime) {
                var byteString = atob(dataURI.split(',')[1]);
                    var ab = new ArrayBuffer(byteString.length);
                    var ia = new Uint8Array(ab);

                    for (var i = 0; i < byteString.length; i++) {
                        ia[i] = byteString.charCodeAt(i);
                    }
                    return new Blob([ab], { type: 'image/png' });
                }
                function base64MimeType(encoded) {
                    var result = null;

                    if (typeof encoded !== 'string') {
                        return result;
                    }

                    var mime = encoded.match(/data:([a-zA-Z0-9]+\/[a-zA-Z0-9-.+]+).*,.*/);

                    if (mime && mime.length) {
                        result = mime[1];
                    }

                    return result;
                }
            </script>