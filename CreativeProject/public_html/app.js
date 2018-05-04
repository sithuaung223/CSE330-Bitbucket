(function () {
  angular.module('rateProfessorApp', ['ui.router'])
  .config([
      '$stateProvider',
      '$urlRouterProvider',
      function ($stateProvider, $urlRouterProvider) {
          //resolve ensures that any time hoome is entered, we always load all posts before state finishes loading
          $stateProvider
              .state('home', {
                  url: '/home',
                  templateUrl: '/home.html',
                  controller: 'MainCtrl',
                  resolve: {
                      postPromise: ['posts', function (posts) {
                              return posts.getAll();
                    }]
                  }
              })
              .state('posts', {
                  url: '/posts/:id',
                  templateUrl: '/posts.html',
                  controller: 'PostsCtrl',
                  resolve: {
                  post: ['$stateParams', 'posts', function ($stateParams, posts) {
                      return posts.get($stateParams.id);
                      }]
                  }
              })
              .state('login', {
                  url: '/login',
                templateUrl: '/login.html',
                controller: 'AuthCtrl',
                onEnter: ['$state', 'auth', function($state, auth){
                      if(auth.isLoggedIn()){
                              $state.go('home');
                                  }
                        }]
              })
              .state('register', {
                  url: '/register',
                templateUrl: '/register.html',
                controller: 'AuthCtrl',
                onEnter: ['$state', 'auth', function($state, auth){
                      if(auth.isLoggedIn()){
                              $state.go('home');
                                  }
                        }]
              });
      $urlRouterProvider.otherwise('home');
  }])

.controller('MainCtrl', ['$scope', 'posts','auth',
  function ($scope, posts,auth) {
      $scope.isLoggedIn = auth.isLoggedIn;
      $scope.posts = posts.posts;

      //set title to blank to prevent empty posts
      $scope.title = '';
      $scope.addPost = function () {
          if ($scope.title.length === 0) {
             alert('Title is required');
              return;
          }
        //check for valid URL
        var isValidUrl = /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.‌​\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[‌​6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1‌​,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00‌​a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u‌​00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$/i;

        var url = $scope.link;

        if($scope.link && !isValidUrl.test(url)) {
          alert('You must include a valid url (ex: http://www.example.com');
            return;
        }
          posts.create({           //mongoose create?
              title: $scope.title,
              link: $scope.link
          });
          //clear the values
          $scope.title = '';
          $scope.link = '';
      };

      $scope.upvote = function (post) {
          //we're calling the upvote() function and passing in our post
          posts.upvote(post);
      };
      $scope.downvote = function (post) {
        posts.downvote(post);
      };
  }])

.controller('PostsCtrl', [
  '$scope',
  'posts',
  'post',
  'auth',
  function ($scope, posts, post,auth) {
      $scope.post = post;
      $scope.isLoggedIn = auth.isLoggedIn;

      $scope.addComment = function () {
          if ($scope.body === '') {
              return;
          }
          posts.addComment(post._id, {
              body: $scope.body,
              author: 'user'
          }).success(function (comment) {
              $scope.post.comments.push(comment);
          });
          $scope.body = '';
      };

      $scope.upvote = function (comment) {
          posts.upvoteComment(post, comment);
      };

      $scope.downvote = function (comment) {
          posts.downvoteComment(post, comment);
      };

  }])
.controller('AuthCtrl', [
    '$scope',
    '$state',
    'auth',
    function($scope, $state, auth){
        $scope.user = {};

          $scope.register = function(){
                auth.register($scope.user).error(function(error){
                        $scope.error = error;
                            }).then(function(){
                                    $state.go('home');
                                        });
                  };

            $scope.logIn = function(){
                  auth.logIn($scope.user).error(function(error){
                          $scope.error = error;
                              }).then(function(){
                                      $state.go('home');
                                          });
                    };
    }])
.controller('NavCtrl', [
    '$scope',
    'auth',
    function($scope, auth){
        $scope.isLoggedIn = auth.isLoggedIn;
          $scope.currentUser = auth.currentUser;
            $scope.logOut = auth.logOut;
    }])

.factory('auth', ['$http', '$window', function($http, $window){
     var auth = {};
     auth.saveToken = function (token){
         $window.localStorage['rate-professor-token'] = token;
     };

     auth.getToken = function (){
         return $window.localStorage['rate-professor-token'];
     }
     auth.isLoggedIn = function(){
         var token = auth.getToken();

           if(token){
                 var payload = JSON.parse($window.atob(token.split('.')[1]));

                     return payload.exp > Date.now() / 1000;
                       } else {
                             return false;
                               }
     };

     auth.currentUser = function(){
         if(auth.isLoggedIn()){
               var token = auth.getToken();
                   var payload = JSON.parse($window.atob(token.split('.')[1]));

                       return payload.username;
                         }
     };
     auth.register = function(user){
         return $http.post('/register', user).success(function(data){
               auth.saveToken(data.token);
                 });
     };
     auth.logIn = function(user){
         return $http.post('/login', user).success(function(data){
               auth.saveToken(data.token);
                 });
     };
     auth.logOut = function(){
         $window.localStorage.removeItem('rate-professor-token');
     };
       return auth;
}])
.factory('posts', ['$http', 'auth', function ($http,auth) {
      var o = {
          posts: []
      };
      // query the '/posts' route and bind a function when request returns
     // get back a list and copy to posts object using angular.copy() - see index.ejs
      o.getAll = function () {
          return $http.get('/posts')
            .success(function (data) {
              angular.copy(data, o.posts);
          });
      };
      // uses router.post in index.js to post a new Post model to mongoDB
      // when $http gets success, it adds this post to the posts object in local factory
      o.create = function(post) {
          return $http.post('/posts', post, {
                headers: {Authorization: 'Bearer '+auth.getToken()}
                           }).success(function(data){
                                 o.posts.push(data);
                                   });
      };

        //use express route for this post's id to add upvote to mongo model
      o.upvote = function(post) {
          return $http.put('/posts/' + post._id + '/upvote', null, {
                headers: {Authorization: 'Bearer '+auth.getToken()}
                           }).success(function(data){
                                 post.votes += 1;
                                   });
      };

      o.downvote = function (post) {
          return $http.put('/posts/' + post._id + '/downvote', null, {
                headers: {Authorization: 'Bearer '+auth.getToken()}
                           }).success(function(data){
                                  post.votes -= 1;
                                   });
      };

      // grab a single post from server
      o.get = function (id) {
          return $http.get('/posts/' + id)
            .then(function (res) {
              return res.data;
          });
      };

      o.addComment = function(id, comment) {
          return $http.post('/posts/' + id + '/comments', comment, {
                headers: {Authorization: 'Bearer '+auth.getToken()}
                           });
      };

      o.upvoteComment = function(post, comment) {
          return $http.put('/posts/' + post._id + '/comments/'+ comment._id + '/upvote', null, {
                headers: {Authorization: 'Bearer '+auth.getToken()}
         }).success(function(data){
           comment.votes += 1;
             });
      };

      o.downvoteComment = function (post, comment) {
          return $http.put('/posts/' + post._id + '/comments/'+ comment._id + '/downvoteComment', null, {
                headers: {Authorization: 'Bearer '+auth.getToken()}
                           }).success(function(data){
                                  comment.votes -= 1;
                                   });
      };




      return o;
  }]);

})();

