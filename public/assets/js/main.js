document.addEventListener('DOMContentLoaded', (event) => {
    const url = new URL('http://localhost:3001/.well-known/mercure');
    url.searchParams.append('topic', '/test');
    const eventSource = new EventSource(url);

    eventSource.onmessage = event => {
        console.log(JSON.parse(event.data));
    }
});