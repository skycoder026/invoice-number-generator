# Description [![Build Status](https://secure.travis-ci.org/jeresig/jquery.hotkeys.png)](http://travis-ci.org/jeresig/jquery.hotkeys)

**User Log** is a small package, that can help you to stored log of created, updated and approved user and also store auth user company.

This is a small package to easy and simplify your code.

## Installation Process

```
composer require skycoder/user-log
```

## Publish View
```php artisan vendor:publish``` press the number which hold `user-log`   


## Uses
You should use `use UserLog;` trait to your model which contain `use Skycoder\UserLog\UserLog;` namespace

And also use `@include('user-log::user-logs', ['data' => $item])` to your table where you display your data. here $item is your model data.

## Example for model

```<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Skycoder\UserLog\UserLog;

class ModelName extends Model
{
    use UserLog;
}
```

## Example For Blade File
```
<table class="table">
      <thead>
          <tr>
              <th>Name</th>
              <th>Mobile</th>
              <th>Email</th>
              <th>Action</th>
          </tr>
      </thead>

      <tbody>
          @foreach ($items as $item)
              <tr>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->mobile }}</td>
                  <td>{{ $item->email }}</td>
                  <td>
                      @include('user-log::user-logs', ['data' => $item])
                  </td>
              </tr>
          @endforeach
      </tbody>
  </table>
```

## Result/Output
