document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('submit').onclick = function () {
    httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function () {
      if (httpRequest.readyState == 4) {
        if (httpRequest.status == 200) {
          document.getElementById('title').value = '';
          document.getElementById('body').value = '';
        } else {
          console.log('С запросом возникла проблема.');
        }
      }

    };

    var json = JSON.stringify({
      title: document.getElementById('title').value,
      body: document.getElementById('body').value
    });

    httpRequest.open('POST', '/api/post', true);
    httpRequest.setRequestHeader("Content-Type", "application/json");
    httpRequest.send(json);

    return false;
  }
});