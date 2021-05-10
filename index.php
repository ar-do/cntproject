<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/ss_main.css">
  </head>
  <body ng-app="app_main" ng-controller="PostController">
    <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Submit a Post</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post" ng-submit="submitPost()">
            <div class="modal-body">
              <textarea class="form-control" id="post_title" rows="1" type="text" ng-model="title"></textarea>
              <textarea class="form-control" id="post_text" rows="3" type="text" ng-model="text"></textarea>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" name="submit" id="submit" class="btn btn-success" value="Post" />
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <nav class="navbar navbar-light bg-light">
      <a class="navbar-brand"><img src="img/logo.png" class="image_navbar"></a>
      <!-- Search Form -->
      <form class="form-inline">
        <input class="form-control mr-sm-2" type="search" placeholder="..." aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
          </svg>
        </button>
      </form>

        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Log In</button>
    </nav>
    <div id="post_frame">

      <div class="blocker"></div>
      <!-- Posts here -->
        <ng-view></ng-view>

    </div>
    <div id="footer_frame">
      <button type="submit" class="btn btn-success btnAdd" data-toggle="modal" data-target="#postModal">
        +
      </button>

    </div>


    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <!-- AngularJS -->
    <script src=js/lib/angular.js></script>
    <script src=js/lib/angular-route.js></script>
    <script src=js/lib/angular-cookies.js></script>

    <!-- Main JS -->
    <script src=js/js_main.js></script>
  </body>
</html>
