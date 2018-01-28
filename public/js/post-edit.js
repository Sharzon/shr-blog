document.addEventListener('DOMContentLoaded', function () {
  httpRequest = new XMLHttpRequest();
  httpRequest.overrideMimeType('application/json');
  httpRequest.onreadystatechange = function(){
    if (httpRequest.readyState == 4) {
      if (httpRequest.status == 200) {
        var post = JSON.parse(httpRequest.responseText);
        document.getElementById('title').value = post.title;
        document.getElementById('body').value = post.body;
      } else {
        console.log('С запросом возникла проблема.');
      }
    }

  };

  var href = window.location.href;
  var id = href.substr(href.lastIndexOf('/')+1);

  httpRequest.open('GET', '/api/post/'+id, true);
  httpRequest.send(null);

  document.getElementById('submit').onclick = function () {
    putRequest = new XMLHttpRequest();
    putRequest.onreadystatechange = function () {
      if (putRequest.readyState == 4) {
        if (putRequest.status == 200) {
          // document.getElementById('title').value = '';
          // document.getElementById('body').value = '';
        } else {
          console.log('С запросом возникла проблема.');
        }
      }

    };

    var json = JSON.stringify({
      title: document.getElementById('title').value,
      body: document.getElementById('body').value
    });

    putRequest.open('PUT', '/api/post/'+id, true);
    putRequest.setRequestHeader("Content-Type", "application/json");
    putRequest.send(json);

    return false;
  }
});

