document.addEventListener('DOMContentLoaded', function () {
  httpRequest = new XMLHttpRequest();
  httpRequest.overrideMimeType('application/json');
  httpRequest.onreadystatechange = function(){
    if (httpRequest.readyState == 4) {
      if (httpRequest.status == 200) {
        var post = JSON.parse(httpRequest.responseText);
        document.getElementById('title').innerHTML = post.title;
        document.getElementById('body').innerHTML = post.body;
        document.getElementById('updated_at').innerHTML = post.updated_at;
      } else {
        console.log('С запросом возникла проблема.');
      }
    }

  };

  var href = window.location.href;
  var id = href.substr(href.lastIndexOf('/')+1);

  httpRequest.open('GET', '/api/post/'+id, true);
  httpRequest.send(null);
});