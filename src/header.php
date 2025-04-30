<!-- header.php -->
<script>
    const source = new EventSource("/sse.php");
    source.onmessage = function(event) {
    document.getElementById("live-data").textContent = "Update: " + event.data;
    };
</script>
