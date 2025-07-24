<div class="transmission-container">
    <whereby-embed
        room="{{$isHost
            ? $meeting->host_room_url
            : $meeting->viewer_room_url
        }}"
    />
</div>

<style>
    .transmission-container {
        width: 100vw;
        height: 100vh;
    }

    whereby-embed {
        width: inherit;
        height: inherit;
        padding: inherit;
        margin: inherit;
    }
</style>

<script src="https://cdn.srv.whereby.com/embed/v2-embed.js" type="module"></script>