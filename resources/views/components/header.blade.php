<header class="sticky-header" id='header'>
    <div class="flex flex-wrap justify-between items-center w-full">
        <a href="{{url('/')}}" class="flex text-xl flex-wrap font-bold items-center">
            <img src="{{asset('images/logo/app_logo.png')}}" alt="" class="w-8 md:w-12">
            <div class="text-lg font-medium">ExamPixel</div>

        </a>
        <nav id='navbar' class="navbar">
            <ul>
                <li class="float-right md:hidden" onclick="toggleNavbarMobile()">
                    <i class="bi-x-lg text-xl text-orange-300 hover:-rotate-90 transition duration-500 ease-in-out"></i>
                </li>
                <li><a href="{{ url('/') }}" class="nav-item">Home</a></li>
                <li><a href="#" class="nav-item">About</a></li>
                <li><a href="{{url('services')}}" class="nav-item">Services</a></li>
                <li><a href="#" class="nav-item">Packages</a></li>
                <li><a href="#" class="nav-item">Contact Us</a></li>
                <li><a href="{{url('login')}}" class="nav-item">Login</a></li>
            </ul>
        </nav>

        <button class="md:hidden" onclick="toggleNavbarMobile()" id='menu'>
            <!-- menu -->
            <i class="bi-list text-lg"></i>
        </button>
    </div>
</header>
<script>
    var header = document.getElementById("header");
    window.onscroll = function() {
        if (window.pageYOffset > 5) {
            header.classList.add("scrolled-down");
        } else {
            header.classList.remove("scrolled-down");
        }
    };

    function toggleNavbarMobile() {
        $('#navbar').toggleClass('mobile');
    }

    function showLoginModal() {
        $('#loginModal').addClass('shown')
    }
</script>