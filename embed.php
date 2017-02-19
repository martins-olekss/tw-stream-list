<script src= "http://player.twitch.tv/js/embed/v1.js"></script>
<div id="twPlayer"></div>
<script type="text/javascript">
    var options = {
        width: 300,
        height: 300,
        channel: "pundurs",
        muted: true,
        autoplay: false
    };
    var player = new Twitch.Player("twPlayer", options);
    player.setVolume(0.5);
</script>