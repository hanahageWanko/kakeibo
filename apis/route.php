<?php
  // users
  Router::set('users/read', function () {
      View::make('users/read');
  });

  Router::set('users/insert', function () {
      View::make('users/read');
  });

  Router::set('users/update', function () {
      View::make('users/update');
  });

  Router::set('users/delete', function () {
      View::make('users/delete');
  });
