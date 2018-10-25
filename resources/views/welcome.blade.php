@extends('layouts.app')

@section('content')

  <table class="app-body">
    <tr>
      <td valign='top' width="368px" class="d-none d-md-table-cell">
    <panel v-bind:class="menu.class"
           v-bind:icon="menu.icon"
           v-bind:name="menu.name"
           v-bind:actions="menu.actions"
           v-bind:direction="menu.direction"
           >
      <tree v-bind:tree="tree" style='width: 320px'>
        <div>
          <span><i $class="row.icon"></i></span>
          <span>{row.name}</span>
          <span>
            <actions $actions="row.actions" $row='row' :action-class="menu.actionClass" #collapse="collapse"></actions>
          </span>
        </div>
      </tree>
    </panel>
    </td>
    <td valign='top' width="1%"></td>
    <td valign="top">
        <router-view></router-view>
    </td>
    <td valign='top' width="1%"></td>
    </tr>
  </table>

@endsection
