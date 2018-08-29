<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{mix('css/app.css')}}" media="screen">
  </head>
  <body>
    <div id="app">
      <div class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="w-100 d-flex">
          <img v-bind:src="logo" class="navbar-logo">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="nav navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="https://www.google.com/" target="_blank">Ayuda</a>
              </li>
              <notification icon="fa fa-bell" v-bind:count-class="topbar.notification.countClass">
                <ul>
                  <li>
                    <a href="mailbox.html" class="dropdown-item">
                      <div>
                        <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                        <span class="float-right text-muted small">4 minutes ago</span>
                      </div>
                    </a>
                  </li>
                  <li class="dropdown-divider"></li>
                  <li>
                    <a href="profile.html" class="dropdown-item">
                      <div>
                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                        <span class="float-right text-muted small">12 minutes ago</span>
                      </div>
                    </a>
                  </li>
                  <li class="dropdown-divider"></li>
                  <li>
                    <a href="grid_options.html" class="dropdown-item">
                      <div>
                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                        <span class="float-right text-muted small">4 minutes ago</span>
                      </div>
                    </a>
                  </li>
                  <li class="dropdown-divider"></li>
                  <li>
                    <div class="text-center link-block">
                      <a href="notifications.html" class="dropdown-item">
                        <strong>See All Alerts</strong>
                        <i class="fa fa-angle-right"></i>
                      </a>
                    </div>
                  </li>
                </ul>
              </notification>
            </ul>
          </div>
        </div>
      </div>
      <table class="app-body">
        <tr>
          <td valign='top' width="1%">
        <panel v-bind:class="menu.class"
               v-bind:icon="menu.icon"
               v-bind:name="menu.name"
               v-bind:actions="menu.actions"
               v-bind:action-class="menu.actionClass"
               v-bind:direction="menu.direction"
               >
          <tree v-bind:tree="tree" style='width: 320px'>
            <span><i $class="row.icon"></i></span>
            <span>{row.name}</span>
            <span>
              <actions $actions="row.actions" $row='row' :action-class="menu.actionClass" #collapse="collapse"></actions>
            </span>
          </tree>
        </panel>
        </td>
        <td valign="top">
        <router-view></router-view>
        </td>
        </tr>
      </table>
    </div>
    <script src="{{mix('js/app.js')}}"></script>
  </body>
</html>
