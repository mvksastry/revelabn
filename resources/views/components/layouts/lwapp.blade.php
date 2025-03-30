<!DOCTYPE html>
<html lang="en">
  @include('components.layouts.partials.header')
  <!--
  `body` tag options:

    Apply one or more of the following classes to to the body tag
    to get the desired effect

    * sidebar-collapse
    * sidebar-mini
  -->
  <body class="hold-transition sidebar-mini">
    <div class="wrapper">
      <!-- Navbar -->
      @include('components.layouts.partials.top-navbar')
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">

        @include('components.layouts.partials.brandlogo')
        <!-- Sidebar -->
        <div class="sidebar">
         @include('components.layouts.partials.left-sidebar')
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>
      {{ $slot }}
    </div>
    <!-- ./wrapper -->
    @include('components.layouts.partials.footer')
    
    @include('components.layouts.partials.scripts')
    @livewireScripts
    @livewire('wire-elements-modal')
    
  </body>
</html>
