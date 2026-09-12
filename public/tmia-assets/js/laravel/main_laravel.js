//================== GET USER LOG IN INFORMATION =================//
$.ajax({
    url: window.dataRoutes.sessionVariable,
    dataType: 'json',
    cache: false,
    success: function(data) {
        ulevel = data.ulevel;

        switch (ulevel) {
        case "PRESIDENT":
        case "EXECUTIVE VICE PRESIDENT":
        case "GENERAL MANAGER":
        case "SERVICE MANAGER":
        case "MAINTENANCE REMINDER STAFF":
            //SHOW CHILD
            document.getElementById("mymenu").children[2].style.display="block";
            document.getElementById("mymenu").children[3].style.display="block";
            document.getElementById("mymenu").children[4].style.display="block";
            // SHOW CHILD CHILDREN
            /*=== Transactions == */
            document.getElementById("mymenuchild0").children[0].style.display="block";
            document.getElementById("mymenuchild0").children[1].style.display="block";
            document.getElementById("mymenuchild0").children[2].style.display="block";
            document.getElementById("mymenuchild0").children[3].style.display="block";
            // document.getElementById("mymenuchild0").children[4].style.display="block";
            /*=== Settings == */
            document.getElementById("mymenuchild1").children[1].style.display="block";
            /*=== Reports == */
            document.getElementById("mymenuchild2").children[0].style.display="block";
            break;
        case "ADMINISTRATOR":
            //SHOW CHILD
            document.getElementById("mymenu").children[2].style.display="block";
            document.getElementById("mymenu").children[3].style.display="block";
            document.getElementById("mymenu").children[4].style.display="block";
            // SHOW CHILD CHILDREN
            /*=== Transactions == */
            document.getElementById("mymenuchild0").children[0].style.display="block";
            document.getElementById("mymenuchild0").children[1].style.display="block";
            document.getElementById("mymenuchild0").children[2].style.display="block";
            document.getElementById("mymenuchild0").children[3].style.display="block";
            // document.getElementById("mymenuchild0").children[4].style.display="block";
            /*=== Settings == */
            document.getElementById("mymenuchild1").children[0].style.display="block";
            document.getElementById("mymenuchild1").children[1].style.display="block";
            /*=== Reports == */
            document.getElementById("mymenuchild2").children[0].style.display="block";
            break;
        default:
            //SHOW CHILD
            document.getElementById("mymenu").children[2].style.display="block";
            document.getElementById("mymenu").children[3].style.display="block";
            document.getElementById("mymenu").children[4].style.display="block";
            // SHOW CHILD CHILDREN
            /*=== Transactions == */
            document.getElementById("mymenuchild0").children[0].style.display="block";
            document.getElementById("mymenuchild0").children[1].style.display="block";
            document.getElementById("mymenuchild0").children[2].style.display="block";
            document.getElementById("mymenuchild0").children[3].style.display="block";
            // document.getElementById("mymenuchild0").children[4].style.display="block";
            /*=== Settings == */
            document.getElementById("mymenuchild1").children[1].style.display="block";
            /*=== Reports == */
            document.getElementById("mymenuchild2").children[0].style.display="block";
            break;
        }
    }
});
//=============== END GET USER LOG IN INFORMATION  =================//

//=============== NOTIFICATIONS ==============//
let lastUnreadCount = 0;
let isLoading = false;
const sound = document.getElementById('notification-sound');

// Escape HTML
function escapeHtml(text) {
  return $('<div>').text(text || '').html();
}

// Bell animation
function ringBell() {
  const bell = $('#notification-bell');
  const hasInfinite = bell.hasClass('bell-ring-infinite');
  if (!hasInfinite) {
    bell.removeClass('bell-ring');
    void bell[0].offsetWidth; // force reflow
    bell.addClass('bell-ring');
  }
}

// Play sound
function playSound() {
  if (!sound) return;
  sound.currentTime = 0;
  sound.play().catch(() => {});
}

// Badge pulse
function pulseBadge() {
  const badge = $('#notification-count');
  badge.addClass('badge-pulse');
  setTimeout(() => badge.removeClass('badge-pulse'), 600);
}

// Load notifications
function loadNotifications() {
  if (isLoading) return;
  isLoading = true;

  $.ajax({
    url: window.nofiticationdata.notifications_data ,
    method: 'GET',
    dataType: 'json',
    success: function(data) {
      const menu = $('#notification-menu');
      menu.empty();

      let unreadCount = 0;
      let hasDangerUnread = false;

      data.forEach(note => {
        let iconClass = 'fa-info-circle text-blue';
        if (note.type === 'success') iconClass = 'fa-check-circle text-green';
        if (note.type === 'warning') iconClass = 'fa-exclamation-triangle text-yellow';
        if (note.type === 'danger') {
          iconClass = 'fa-exclamation-circle text-red';
          if (note.Status === 'unread') hasDangerUnread = true;
        }
        if (note.Status === 'unread') unreadCount++;

        menu.append(`
          <li class="${note.Status === 'unread' ? 'unread-notification' : ''}"
              data-id="${note.ID}"
              data-insuranceno="${note.Insurance_No}"
              data-url="${note.URL || ''}">
            <a href="#" class="notification-item">
              <span class="notification-title">
                <i class="fa ${iconClass}"></i>
                ${escapeHtml(note.Title)}
              </span>
              <p class="notification-message">
                ${escapeHtml(note.Message)}
              </p>
            </a>
          </li>
        `);
      });

      if (unreadCount > 0 && unreadCount !== lastUnreadCount) {
        ringBell();
        playSound();
        pulseBadge();
      }

      const bell = $('#notification-bell');
      bell.toggleClass('bell-ring-infinite', hasDangerUnread);

      lastUnreadCount = unreadCount;

      $('#notification-count').text(unreadCount);
      $('#notification-header').text(`You have ${unreadCount} notification${unreadCount !== 1 ? 's' : ''}`);
    },
    error: function(xhr, status, error) {
      console.error('Error loading notifications:', error);
    },
    complete: function() {
      isLoading = false;
    }
  });
}

// Mark as read
$(document).on('click', '#notification-menu li a', function(e) {
  e.preventDefault();
  const li = $(this).closest('li');
  const id = li.data('id');
  const insuranceno = li.data('insuranceno');
  const url = li.data('url');

  if (!id) return;

  $.ajax({
    url: 'notifications_mark_read.php',
    method: 'GET',
    data: { id: id },
    success: function() {
      li.removeClass('unread-notification');

      const unreadCount = $('#notification-menu li.unread-notification').length;
      $('#notification-count').text(unreadCount);
      $('#notification-header').text(`You have ${unreadCount} notification${unreadCount !== 1 ? 's' : ''}`);

      const hasDangerUnread = $('#notification-menu li.unread-notification .fa-exclamation-circle.text-red').length > 0;
      if (!hasDangerUnread) $('#notification-bell').removeClass('bell-ring-infinite');

      $.post('send_variable.php', { insuranceno: insuranceno })
        .done(() => { if (url) window.location.href = url; });
    },
    error: function(xhr, status, error) {
      console.error('Error marking notification as read:', error);
    }
  });
});

// Smooth dropdown animation
$('#notification-toggle').parent().on('show.bs.dropdown', function() {
  $(this).find('.dropdown-menu').stop(true, true).slideDown('fast');
});
$('#notification-toggle').parent().on('hide.bs.dropdown', function() {
  $(this).find('.dropdown-menu').stop(true, true).slideUp('fast');
});

// Auto-refresh every 10 seconds
setInterval(loadNotifications, 10000);
loadNotifications();
//============= END NOTIFICATIONS ============//

//============= EXPIRATION NOTIFICATIONS & PROMISED PAYMENT DATE NOTIFICATIONS ============//
//============= CONFIG ============//
const NOTIFY_DELAY = 10000; // 10 seconds
const ONE_DAY_MS = 24 * 60 * 60 * 1000;

// Global CSS for icons and titles
$(`<style>
[data-notify="icon"] { font-size: 18px; margin-right: 3px; }
[data-notify="title"] { font-size: 18px; font-weight: bold; }
</style>`).appendTo("head");

//============= DATE UTILITIES (LOCAL TIME) ============//
function isSameDay(d1, d2) {
    return d1.getFullYear() === d2.getFullYear() &&
           d1.getMonth() === d2.getMonth() &&
           d1.getDate() === d2.getDate();
}

function formatDaysText(daysLeft) {
    return daysLeft === 0 ? "today" : `${daysLeft} day${daysLeft > 1 ? "s" : ""}`;
}

//============= GENERIC FETCH & QUEUE FUNCTION ============//
function fetchNotifications(endpointUrl, storageKeyPrefix, getItemConfigCallback, callback) {
    $.ajax({
        url: endpointUrl,
        method: "POST",
        dataType: "json",
        success: function(data) {
            const itemsKey = Object.keys(data)[0];
            const now = new Date();
            const queue = [];

            if (!data[itemsKey]?.length) {
                callback(queue);
                return;
            }

            data[itemsKey].forEach(item => {
                const dateField = item.Policy_Expiration || item.Promised_Pay_Date;
                if (!dateField) return;

                const itemDate = new Date(dateField);
                itemDate.setHours(0, 0, 0, 0); // ignore time

                const today = new Date();
                today.setHours(0, 0, 0, 0);

                const rawDays = Math.ceil((itemDate - today) / ONE_DAY_MS);
                const daysLeft = Math.max(0, rawDays);

                if (rawDays < 0) return;

                const uniqueId = item.Insurance_No || item.id;
                const storageKey = `${storageKeyPrefix}${uniqueId}`;
                const lastShownRaw = localStorage.getItem(storageKey);
                const lastShownDate = lastShownRaw ? new Date(lastShownRaw) : null;

                const canShow = !lastShownDate || !isSameDay(now, lastShownDate);

                if (canShow) {
                    queue.push({
                        id: uniqueId,
                        Full_Name: item.Full_Name,
                        Insurance_No: item.Insurance_No,
                        daysLeft,
                        daysText: formatDaysText(daysLeft),
                        storageKey,
                        config: getItemConfigCallback({ ...item, daysLeft })
                    });
                }
            });

            callback(queue);
        },
        error: function(xhr, status, error) {
            console.error(`Fetch failed: ${endpointUrl}`, {
                status,
                error,
                response: xhr.responseText
            });
            callback([]);
        }
    });
}

//============= SHOW QUEUE SEQUENTIALLY ============//
function showSequentialNotifications(queue, index = 0) {
    if (index >= queue.length) return;

    const item = queue[index];

    // Mark as shown immediately (prevents multi-tab duplicates)
    localStorage.setItem(item.storageKey, new Date().toISOString());

    $.notify({
        icon: item.config.icon,
        title: `<span>${item.config.title}</span>`,
        message: item.config.message
    }, {
        type: item.config.type,
        placement: { from: "bottom", align: "right" },
        delay: NOTIFY_DELAY,
        allow_dismiss: true,
        z_index: 9999,
        animate: { enter: "animated fadeInUp", exit: "animated fadeOutDown" },
        template: `
            <div data-notify="container" class="col-xs-11 col-sm-4 alert alert-{0}" role="alert">
                <span data-notify="icon"></span>
                <span data-notify="title" margin-bottom: 5px;">{1}</span>
                <span data-notify="message" style="display: block;">{2}</span>
            </div>`
    });

    setTimeout(() => showSequentialNotifications(queue, index + 1), NOTIFY_DELAY + 500);
}

//============= CONFIG CALLBACKS ============//
function getPolicyExpiryConfig(sub) {
    const displayName = `${sub.Full_Name} (${sub.Insurance_No})`;
    let type = "info", title = "", message = "", icon = "fa-regular fa-calendar-days";

    if (sub.daysLeft === 0) {
        type = "danger";
        title = "Policy Expires Today!";
        message = `${displayName} expires today. Renew immediately to avoid interruption.`;
        icon = "fa-solid fa-triangle-exclamation";
    } else if (sub.daysLeft <= 30) {
        type = "danger";
        title = "Policy Expiring Soon!";
        message = `${displayName} expires in ${sub.daysLeft} day${sub.daysLeft > 1 ? "s" : ""}. Renew now.`;
        icon = "fa-solid fa-triangle-exclamation";
    } else if (sub.daysLeft <= 60) {
        type = "warning";
        title = "Reminder: Policy Expiration";
        message = `${displayName} expires in ${sub.daysLeft} day${sub.daysLeft > 1 ? "s" : ""}.`;
        icon = "fa-regular fa-alarm-clock";
    } else if (sub.daysLeft <= 90) {
        type = "info";
        title = "Policy Expiration Notice";
        message = `${displayName} expires in ${sub.daysLeft} day${sub.daysLeft > 1 ? "s" : ""}.`;
    }

    return { type, title, message, icon };
}

function getPaymentConfig(item) {
    const displayName = `${item.Full_Name} (${item.Insurance_No})`;
    let type = "info", title = "", message = "", icon = "fa-regular fa-calendar-days";

    if (item.daysLeft === 0) {
        type = "danger";
        title = "Payment Due Today!";
        message = `${displayName} must pay today. Follow up immediately.`;
        icon = "fa-solid fa-triangle-exclamation";
    } else if (item.daysLeft <= 3) {
        type = "danger";
        title = "Payment Due Soon!";
        message = `${displayName} must pay in ${item.daysLeft} day${item.daysLeft > 1 ? "s" : ""}. Follow up.`;
        icon = "fa-solid fa-triangle-exclamation";
    } else if (item.daysLeft <= 5) {
        type = "warning";
        title = "Reminder: Payment Due";
        message = `${displayName} has a promised payment due in ${item.daysLeft} day${item.daysLeft > 1 ? "s" : ""}.`;
        icon = "fa-regular fa-alarm-clock";
    } else if (item.daysLeft <= 7) {
        type = "info";
        title = "Upcoming Payment Reminder";
        message = `${displayName} has a promised payment due in ${item.daysLeft} day${item.daysLeft > 1 ? "s" : ""}.`;
    }

    return { type, title, message, icon };
}

//============= FETCH BOTH QUEUES & MERGE ============//
let allNotificationsQueue = [];

fetchNotifications("fetch_promised_pay_date.php", "notify_payment_", getPaymentConfig, function(paymentQueue) {
    allNotificationsQueue = paymentQueue;

    fetchNotifications("fetch_insurance_expiry.php", "notify_policy_expiry_", getPolicyExpiryConfig, function(expirationQueue) {
        allNotificationsQueue = allNotificationsQueue.concat(expirationQueue);

        // Sort by urgency (most critical first)
        // allNotificationsQueue.sort((a, b) => a.daysLeft - b.daysLeft);

        showSequentialNotifications(allNotificationsQueue);
    });
});
//============= END EXPIRATION NOTIFICATIONS & PROMISED PAYMENT DATE NOTIFICATIONS ============//

//============== SIGN OUT BUTTON ============//
$(document).on("click",".btnsignout",function(){
  $.ajax({
    url : "send_signout.php",
    type: "POST",
    success: function(data)
    {
      var isMobile = false; //initiate as false
      // device detection
      if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
          || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))){
          isMobile = true;
          window.location.replace('mobile_login');
      } else {
          window.location.replace('login');
      }
    }
  });
});
//============= END SIGN OUT BUTTON ============//

$.notifyDefaults({
  type: "success",
  delay: 600
});