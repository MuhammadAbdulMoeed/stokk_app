<script>

    (async function () {

        console.log('Hello Ticketmaster');
        var url = window.location.href;
        var splits = url.split("\/");
        var sp = splits[splits.length - 1].split("?")
        var eventID = sp[0];
        // var request_url = `https://services.ticketmaster.ca/api/ismds/event/0E005B9E487F4235/spacing?apikey=b462oi7fic6pehcdkzony5bxhe&apisecret=pquzpfrfz7zd2ylvtz3w5dtyse&_=1648641532690`;
        var request_url = `https://services.ticketmaster.com/api/ismds/event/0E005B9E487F4235/facets?show=count+row+listpricerange+places+maxQuantity+sections+shape&q=available&apikey=b462oi7fic6pehcdkzony5bxhe&apisecret=pquzpfrfz7zd2ylvtz3w5dtyse&resaleChannelId=internal.ecommerce.consumer.desktop.web.browser.ticketmaster.us`
        // 0E005B9E487F4235
        // 11005B8EC02B3423
        var res = await getSectionData(request_url);
        var imgUrl, eventName, eventDate, venue;
        // imgUrl = document.querySelector('[data-bdd="event-info-image"] img').getAttribute('src');
        try {
            // eventName = document.querySelector('[data-bdd="event-header-title"] span').innerHTML.trim();
            // eventDate = document.querySelector('[data-bdd="event-header-datetime"]').innerHTML.trim();
            // venue = document.querySelector('[data-bdd="event-venue-info"]').innerText;

            console.log(eventName,eventDate,venue);
        } catch (error) {
            eventName = document.querySelector('[data-bdd="bba-event-header-title"] span').innerHTML.trim();
            eventDate = document.querySelector('[data-bdd="bba-event-header-date"]').innerHTML.trim();
            venue = document.querySelector('[data-bdd="bba-event-header-venue"]').innerText;
        }
        headerInfo = {
            imgUrl, eventName, eventDate, venue
        }
        if (res.status) {
            res.data.headerInfo = headerInfo
            console.log("EventId is: "+res.data.eventId);
            // chrome.runtime.sendMessage({data: res.data, type: 'ticketmaster', status: true});
        } else {
            chrome.runtime.sendMessage({type: 'ticketmaster', status: false});
        }

    })();

    function getSectionData(url) {


        return new Promise((resolve) => {
            var xhr = new XMLHttpRequest();
// xhr.withCredentials = true;
            xhr.addEventListener("readystatechange", function () {
                if (this.readyState === 4) {
                    try {
                        if (this.status == 404) {
                            resolve({
                                status: false
                            })
                        } else {
                            resolve({
                                status: true,
                                data: JSON.parse(xhr.responseText)
                            })
                        }
                    } catch (e) {
                        resolve({
                            status: false
                        })
                    }

                }
            });

            xhr.open("GET", url);
            xhr.setRequestHeader("TMPS-Correlation-Id", uuidv4());
            xhr.send();

            console.log(uuidv4());
        })

    }


    function uuidv4() {
        return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
            (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
        );
    }

</script>
