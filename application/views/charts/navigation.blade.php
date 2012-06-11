<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">

            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>

            <a class="brand" href="./c/chris">My Stock Charts</a>

            <a class="btn pull-right" data-toggle="modal" href="#settings">
                <i class="icon-cog"></i> Settings
            </a>

            <a class="btn pull-right" data-toggle="modal" href="#addSymbol">
                <i class="icon-plus"></i> Add New Symbol
            </a>

            <div class="nav-collapse">
              <ul class="nav">
                <li class="{{URI::is('c/tech')?'active':''}}"><a href="./c/tech">Tech</a></li>
                <li class="{{URI::is('c/hardware')?'active':''}}"><a href="./c/hardware">Hardware</a></li>
                <li class="{{URI::is('c/software')?'active':''}}"><a href="./c/software">Software & Web</a></li>
                <li class="{{URI::is('c/photo')?'active':''}}"><a href="./c/photo">Photo & Video</a></li>
                <li class="{{URI::is('c/entertainment')?'active':''}}"><a href="./c/entertainment">Entertainment</a></li>
                <li class="{{URI::is('c/retail')?'active':''}}"><a href="./c/retail">Retail</a></li>
              </ul>
            </div>

        </div>
    </div>
</div>

