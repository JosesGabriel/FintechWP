

localStorage.setItem('vyndue-notifications', 0)
function getVyndueNotifications() {
    if (typeof localStorage.getItem('vyndue-notifications') !== null) {
        return localStorage.getItem('vyndue-notifications')
    }
    return 0
}

function setVyndueNotifications(count) {
    localStorage.setItem('vyndue-notifications', count)
}

function updateVyndueNotifications(count) {
    var $notif = jQuery('#main-header .dmessagepart').find('.vyndue-notification');
    $notif.text(count)

    setVyndueNotifications(count)
    
    if (count != 0) {
        $notif.addClass('has-notification')
    } else {
        $notif.removeClass('has-notification')
    }
}


(function ($, updateVyndueNotifications, getVyndueNotifications) {
    
    updateVyndueNotifications(getVyndueNotifications())

    $.ajax({
        url: 'https://vyndue.com/api/messages/get_unread',
        crossDomain: true,
        data: {
            "user_secret": scriptVars.user_secret,
        },
        // dataType: "jsonp",
        headers: {
            "accept": "application/json",
            "Access-Control-Allow-Origin":"*",
            'Content-Type' : 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        type: 'POST',
        success: function (data) {
            if (data.status >= 200 && data.status <= 299) {
                updateVyndueNotifications(data.data.unread)
            }
        }
    })

    $(document)
        .on('click', '#main-header .dmessagepart', function (e) {
            updateVyndueNotifications(0)
        })
})(jQuery, updateVyndueNotifications, getVyndueNotifications)