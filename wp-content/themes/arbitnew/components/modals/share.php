<?php 
$currentUser = $current_user->ID;
?>
<div class="dbuttonenter" style="margin-right: 1px;">
    <a href="javascript:void(0)" id="share__btn" data-toggle="modal" data-target="#share" class="fancybox-inline enter-trade-btn" style="font-weight: 400;">Share</a>
</div>

<div class="modal fade share-modal" id="share" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <input type="hidden" value="<?php echo $currentUser ?>" id="inpt_current_user">
            <div class="modal-header share-modal-header" >
                <div class="share--modal__socialWrapper">
                    <span>Share on: </span>
                    <button class="btn share__btn--social" onclick="shareOnFB();"><i class="fab fa-facebook-f"></i></button>
                    <button class="btn share__btn--social" onclick="shareOnTwitter()"><i class="fab fa-twitter"></i></button>
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
                <textarea rows="3" placeholder="Say something about this..." id="form-share-postarea"></textarea>
                <input type="button" onclick="shareOnArbitrage()" class="arbitrage-button arbitrage-button--primary" style="float: right;" value="Submit">
            </div>
        </div>
        
    </div>
</div>
<script>
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=407039123333666&version=v2.0&message=This%20is%20awesome!";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<script type="text/javascript">
    function shareOnArbitrage() {
        let postField = $('#form-share-postarea').val();
        let authorId = $('#inpt_current_user').val();
        var imageLink;

        var imageData = $('#image-to-share').attr('src');
        var image = dataURLtoFile(imageData, 'screenshot.png');
        var formData = new FormData();
        formData.append('file', image);
        $.ajax({ //post to cloud
            url: 'https://dev-api.arbitrage.ph/api/storage/upload',
            data: formData,
            type: 'POST',
            contentType: false,
            processData: false,  
            success: function(response) {
                imageLink = response.data.file.url;
                imageLink = decodeURIComponent(imageLink);
                $.ajax({
                    method: "GET",
                    url: "/apipge/?daction=share_post&link=" + imageLink + "&caption=" + postField + "&authorId=" + authorId,
                    success: function(data) {

                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            },
            error: function(e) {
                console.log(e);
            }
        });
    }
    function shareOnFB() {
        var imageData = $('#image-to-share').attr('src');
        var image = dataURLtoFile(imageData, 'screenshot.png');
        var formData = new FormData();
        formData.append('file', image);
        $.ajax({ //post to cloud
            url: 'https://dev-api.arbitrage.ph/api/storage/upload',
            data: formData,
            type: 'POST',
            contentType: false,
            processData: false,  
            success: function(response) {
                var imageLink = response.data.file.url;
                FB.ui({
                    method: 'feed',
                    link: imageLink,
                    quote: 'https://arbitrage.ph'
                }, function(response){});
            },
            error: function(e) {
                console.log(e);
            }
        });
        
    }
    function shareOnTwitter() {
        var imageData = $('#image-to-share').attr('src');
        var image = dataURLtoFile(imageData, 'screenshot.png');
        var formData = new FormData();
        formData.append('file', image);
        $.ajax({ //post to cloud
            url: 'https://dev-api.arbitrage.ph/api/storage/upload',
            data: formData,
            type: 'POST',
            contentType: false,
            processData: false,  
            success: function(response) {
                var imageLink = response.data.file.url;
                imageLink = encodeURIComponent(imageLink);
                var twitterURL = 'https://twitter.com/intent/tweet?url=' + imageLink + '&via=arbitrageph&hashtags=arbitrageph';
                window.open(twitterURL,"mywindow","menubar=1,resizable=1,width=350,height=250");
            },
            error: function(e) {
                console.log(e);
            }
        });
    }
    function dataURLtoFile(dataurl, filename) {
        var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
        while(n--){
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new File([u8arr], filename, {type:mime});
    }
</script>