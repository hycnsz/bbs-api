{{-- 基础视图 --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
{{-- app()->getLocale() 获取的是 config/app.php 中的 locale 选项。 value=zh-cn --}}
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'LaraBBS') - {{ setting('site_name', 'Laravel 进阶教程') }}</title>
  <meta name="description" content="@yield('description', setting('seo_description', 'LaraBBS 爱好者社区。'))" />
  <meta name="keyword" content="@yield('keyword', setting('seo_keyword', 'LaraBBS,社区,论坛,开发者论坛'))" />

  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  {{-- mix('css/app.css') 会根据 webpack.mix.js 的逻辑来生成 CSS 文件链接。 --}}
  @yield('styles')

</head>

<body>
  <div id="app" class="{{ route_class() }}-page">
    {{-- route_class() 是我们自定义的辅助方法，app/helpers.php --}}

    @include('layouts._header')
    {{-- 加载顶部导航区块的子模板。 --}}
    <div class="container">

      @include('shared._messages')

      @yield('content')
      {{-- 占位符声明，允许继承此模板的页面注入内容。 --}}
    </div>

    @include('layouts._footer')
    {{-- 加载页面尾部导航区块的子模板 --}}
  </div>

  @if (app()->isLocal())
    @include('sudosu::user-selector')
  @endif

  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}"></script>

  @yield('scripts')

</body>

</html>