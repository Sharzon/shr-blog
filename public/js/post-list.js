function removePost(id){
  var deleteRequest = new XMLHttpRequest();
  deleteRequest.onreadystatechange = function () {
    if (deleteRequest.readyState == 4) {
      if (deleteRequest.status == 200) {
        document.getElementById('post_'+id).remove();
      } else {
        console.log('С запросом возникла проблема.');
      }
    }

  };

  deleteRequest.open('DELETE', '/api/post/'+id, true);
  deleteRequest.send(null);

}

function addPostToPage(post) {
  var row = document.createElement('div');
  row.id = "post_"+post.id;
  row.classList.add('row');
  row.innerHTML =
    '<div class="col-md-8 col-md-offset-2">\n' +
    '  <div class="panel panel-default">\n' +
    '    <div class="panel-heading">\n' +
    '    </div>\n' +
    '    <div class="panel-body">\n' +
    '    </div>\n' +
    '    <div class="panel-footer">\n' +
    '    </div>' +
    '  </div>\n' +
    '</div>';

  var heading = row.getElementsByClassName("panel-heading")[0];
  heading.innerHTML = "<a href='/post/"+post.id+"'>"+post.title+"</a>";
  var body = row.getElementsByClassName("panel-body")[0];
  body.innerHTML = post.body;
  var footer = row.getElementsByClassName('panel-footer')[0];
  footer.innerHTML =
    '     <div>' +
    '       <a href="/post/edit/'+post.id+'" class="btn btn-primary">' +
    '         Edit' +
    '       </a>' +
    '       <button onclick="removePost('+post.id+')" class="btn btn-danger">' +
    '         Remove' +
    '       </button>' +
    '       <div class="btn btn-link pull-right"><a href="post/'+post.id+'">'+post.updated_at+'</a></div>' +
    '       <div class="clearfix"></div> ' +
    '     </div>';

  var container = document.getElementById('container');
  container.appendChild(row);
}

function setPosts(httpRequest) {
  if (httpRequest.readyState == 4) {
    if (httpRequest.status == 200) {
      var posts = JSON.parse(httpRequest.responseText);

      for (var i = 0; i < posts.length; i++) {
        addPostToPage(posts[i]);
      }
    } else {
      console.log('С запросом возникла проблема.');
    }
  }
}


document.addEventListener('DOMContentLoaded', function () {
  httpRequest = new XMLHttpRequest();
  httpRequest.overrideMimeType('application/json');
  httpRequest.onreadystatechange = function(){
    setPosts(httpRequest);
  };

  httpRequest.open('GET', '/api/post', true);
  httpRequest.send(null);
});