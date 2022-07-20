<!-- START NAVBAR -->
<div class="container">
    <div class="row" id="home-navbar">
        <div class="navbar__logo">
            <a class="navbar-brand d-lg-flex" href="{{ route('/') }}">
                <img class="img-fluid" src="{{ asset('/') }}/adminAsset/assets/images/logo--company-name-dark.svg" alt="phone list" />
            </a>
        </div>

        <nav class="navbar navbar--center d-lg-flex d-none">
            <ul class="navbar__ul">
                <li class="navbar__li">
                    <a href="{{ route('product') }}" class="navbar__a"> Product </a>
                </li>
                <li class="navbar__li">
                    <a href="{{ route('packages') }}" class="navbar__a"> Pricing </a>
                </li>
                <li class="navbar__li">
                    <a href="https://blog.phonelist.io" class="navbar__a"> Blog </a>
                </li>
                <li class="navbar__li">
                    <a href="{{ route('careers') }}" class="navbar__a"> Careers </a>
                </li>
            </ul>
        </nav>
        <nav class="navbar navbar--right d-lg-flex d-none">
            <ul class="navbar__ul align-items-center">
                <li class="navbar__li d-flex align-items-center me-5">
              <!-- START TRANSLATOR -->
<a href="#" onclick="doGTranslate('en|en');return false;" title="English" class="gflag nturl"
                style="background-position:-0px -0px;"><img src="//gtranslate.net/flags/blank.png" height="16"
                  width="16" alt="English" /></a>

              <br /> <select onchange="doGTranslate(this);"><option value="">Select Language</option><option value="en|zh-CN">Chinese (Simplified)</option><option value="en|zh-TW">Chinese (Traditional)</option><option value="en|en">English</option><option value="en|fr">French</option><option value="en|hi">Hindi</option><option value="en|ja">Japanese</option><option value="en|ko">Korean</option><option value="en|pt">Portuguese</option><option value="en|es">Spanish</option></select>
              <div id="google_translate_element2"></div>
              <!-- END TRANSLATOR -->
            </li>
                @guest
                    <li class="navbar__li">
                        <a href="{{ route('/phonelistUserLogin') }}" class="navbar__a"> Account </a>
                    </li>
                @else
                    <li class="navbar__li">
                        <a href="{{ route('loggedInUser') }}" class="navbar__a"> Account </a>
                    </li>
                @endguest

            </ul>
        </nav>
    </div>
</div>
<!-- END NAVBAR -->
