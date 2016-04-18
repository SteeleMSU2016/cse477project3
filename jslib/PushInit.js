/**
 * Created by MatthewWiechec on 4/9/16.
 */
/**
 * Initialize monitoring for a server push command.
 * @param key Key we will receive.
 */
    function pushInit(key) {
    var conn = new WebSocket('ws://webdev.cse.msu.edu:8079');
    conn.onopen = function (e) {
        console.log("Connection to push established!");
        conn.send(key);
    };

    conn.onmessage = function (e) {
        try {
            var msg = JSON.parse(e.data);
            if (msg.cmd === "reload") {
                //location.reload();
                $.ajax({
                    url: "steampunked-post.php",
                    data: {
                        getView: true
                    },
                    method: "POST",
                    success: function(data) {
                        try {
                            var json = $.parseJSON(data);
                        } catch(err) {
                            throw "JSON parse error: " + json;
                            return;
                        }

                        if (json.message == 'ok') {
                            $('form').html(json.html);
                            new Steampunked('form').installButtonListeners();
                        } else {
                            console.log('failed to discard piece');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('failed');
                    }
                });
            }
        } catch (e) {
        }
    };

    console.log("pushInit");
}