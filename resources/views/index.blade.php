@extends('layouts.basic')

@section('header')
<x-header></x-header>
@endsection

@section('body')
<section>
    <div class="w-screen h-screen bg-white">
        <div class="p-5 md:w-3/4 mx-auto flex flex-col justify-center items-center text-center h-full">
            <img src="{{ asset('/images/illustrations/mobile-map-min.png') }}" alt="bg" class="w-96 mx-auto md:mt-16">
            <p class="text-2xl md:text-4xl mt-6 font-bold text-slate-800">Question Paper <span class="text-teal-600">by Click</span> </p>
            <p class="text-slate-600 mt-5 text-sm md:text-xl leading-relaxed font-normal">Question paper generation is no more a laborious work. Just signup and create fully customized question paper from grade 9-12 within few clicks only.</p>
            <div class="flex flex-col md:flex-row items-center justify-center gap-2 mt-8 w-full">
                <a href="{{ url('login') }}" class="w-64">
                    <button class="btn-teal rounded py-3 w-full">Start Now</button>
                </a>

            </div>

        </div>
    </div>
</section>
<!-- self test section -->
<section>
    <div class="bg-teal-100 ">
        <div class="md:w-3/4 mx-auto grid md:grid-cols-3">
            <div class="p-5 md:p-12 md:col-span-2">
                <h1 class="text-2xl font-bold">Self Testing</h1>
                <p class="text-slate-600 text-sm md:text-lg leading-relaxed mt-1">
                    Unlock your true potential with our self-testing feature! It's your ultimate companion for exam success, helping you identify strengths, target weak spots, and build confidence. With every test, you’ll master your subjects step by step, turning challenges into achievements. Start self-testing today and take charge of your learning journey! </p>
                <div class="mt-8">
                    <a href="{{ route('self-tests.index') }}" class="btn-teal rounded-full text-sm px-4 py-2">Start Now</a>
                </div>
            </div>
            <div class="place-items-center place-content-end">
                <img src="{{ asset('/images/illustrations/quiz-min.png') }}" alt="quiz" class="w-48 sm:w-64 md:w-96">
            </div>
        </div>
    </div>
</section>
<!--Impact section -->
<section>
    <div class="p-5 sm:p-12 bg-gray-900">
        <div class="w-5/6 sm:w-3/5 mx-auto">
            <div class="text-center">
                <h2 class="text-2xl md:text-4xl font-bold leading-9 text-teal-500">
                    Our Growth Impact in Numbers
                </h2>
                <p class="mt-6 leading-7 text-gray-400 text-sm sm:text-lg">
                    Discover the milestones we've achieved! See our growing community, volume of question bank, and number of question papers generated—each number reflecting our commitment to empowering learners and making a difference. </p>
            </div>
        </div>

        <div class="w-5/6 md:w-3/4 mx-auto relative mt-6 sm:mt-12 mb-6 sm:mb-0">
            <dl class="bg-white rounded-lg shadow-lg sm:grid sm:grid-cols-3">
                <div
                    class="flex flex-col p-6 text-center border-b border-gray-100 dark:border-gray-600 sm:border-0 sm:border-r">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500" id="item-1">
                        Questions
                    </dt>
                    <dd class="order-1 text-3xl font-bold leading-none text-teal-600"
                        aria-describedby="item-1" id="starsCount">
                        0
                    </dd>
                </div>
                <div
                    class="flex flex-col p-6 text-center border-t border-b border-gray-100 dark:border-gray-600 sm:border-0 sm:border-l sm:border-r">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-slate-600">
                        Users
                    </dt>
                    <dd class="order-1 text-3xl font-bold leading-none text-teal-600"
                        id="downloadsCount">
                        0
                    </dd>
                </div>
                <div
                    class="flex flex-col p-6 text-center border-t border-gray-100 dark:border-gray-700 sm:border-0 sm:border-l">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-gray-500 dark:text-gray-400">
                        Paper Generated
                    </dt>
                    <dd class="order-1 text-3xl font-bold leading-none text-teal-600"
                        id="sponsorsCount">
                        0
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</section>
<script>
    const targets = [{
            element: document.getElementById('starsCount'),
            count: 42000,
            suffix: '+'
        },
        {
            element: document.getElementById('downloadsCount'),
            count: 150,
            suffix: '+'
        },
        {
            element: document.getElementById('sponsorsCount'),
            count: 1000,
            suffix: '+'
        }
    ];

    // Find the maximum count among all targets
    const maxCount = Math.max(...targets.map(target => target.count));

    // Function to animate count-up effect
    function animateCountUp(target, duration) {
        let currentCount = 0;
        const increment = Math.ceil(target.count / (duration / 10));

        const interval = setInterval(() => {
            currentCount += increment;
            if (currentCount >= target.count) {
                clearInterval(interval);
                currentCount = target.count;
                target.element.textContent = currentCount + target.suffix;
            } else {
                target.element.textContent = currentCount;
            }
        }, 10);
    }

    // Animate count-up for each target with adjusted duration
    targets.forEach(target => {
        animateCountUp(target, maxCount / 100); // Adjust duration based on max count
    });
</script>

<!-- FAQ -->
<div class="py-4 max-w-screen-sm mx-auto">
    <div class="text-center mb-16">
        <p class="mt-4 text-sm leading-7 text-gray-500 font-regular">
            F.A.Q
        </p>
        <h3 class="text-2xl sm:text-4xl leading-normal font-bold tracking-tight text-gray-900">
            Frequently Asked <span class="text-teal-600">Questions</span>
        </h3>
    </div>

    <div class="px-10 sm:px-16">
        <div class="flex items-start my-8">
            <div class="hidden sm:flex w-12 h-12 p-4 rounded-full items-center justify-center mr-3  bg-teal-500 text-white text-xl font-semibold">
                <i class="bi-question-lg"></i>
            </div>
            <div class="text-md">
                <h1 class="text-gray-900 font-semibold mb-2">Is it really free?</h1>
                <p class="text-gray-500 text-sm">Sure! Our services are totally free. Feel easy to create question papers of your own choice and share with others</p>
            </div>
        </div>
        <div class="flex items-start my-8">
            <div class="hidden sm:flex w-12 h-12 p-4 rounded-full items-center justify-center mr-3  bg-teal-500 text-white text-xl font-semibold">
                <i class="bi-question-lg"></i>
            </div>
            <div class="text-md">
                <h1 class="text-gray-900 font-semibold mb-2">How can I start paper generation?</h1>
                <p class="text-gray-500 text-sm">Fill and submit signup form. A randomly generated password will be sent to your email. Check your inbox or spam folder</p>
            </div>
        </div>
        <div class="flex items-start my-8">
            <div class="hidden sm:flex w-12 h-12 p-4 rounded-full items-center justify-center mr-3  bg-teal-500 text-white text-xl font-semibold">
                <i class="bi-question-lg"></i>
            </div>
            <div class="text-md">
                <h1 class="text-gray-900 font-semibold mb-2">How can I recover my lost password?</h1>
                <p class="text-gray-500 text-sm">Go to Forgot Password option available at login page. Provide email and submit. New password will be sent to your email.</p>
            </div>
        </div>

    </div>

</div>

<!-- Team Section -->
<section class="testimonials pt-0">
    <div class="mt-12 px-4 md:px-16 md:w-3/4 mx-auto">
        <h2 class="text-2xl md:text-4xl text-center font-bold">Our Team</h2>
        <p class="text-gray-600 text-center mt-8 text-sm sm:text-lg">
            Our software development team comprises of highly skilled and dedicated professionals who are 24/7 ready to
            support you. We are also in collaboration with supject experts in order to ensure the quality of
            question bank.
        </p>
        <div class="h-1 w-24 bg-teal-800 mx-auto mt-6"></div>
    </div>
    <div class="testimonials-carousel swiper w-full md:w-3/4 mx-auto mt-12">
        <div class="swiper-wrapper">
            <div class="testimonial-item swiper-slide">
                <img src="{{ asset('images/illustrations/coding-min.png') }}" class="testimonial-img rounded-full" alt="developers">
                <h3>Muhammad Abbas</h3>
                <h4>Subject Specialist, Web Developer</h4>
            </div>

            <div class="testimonial-item swiper-slide">
                <img src="{{ asset('images/illustrations/coding-min.png') }}" class="testimonial-img rounded-full" alt="developers">
                <h3>Azeem Rehan</h3>
                <h4>IT Officer, Android Developer</h4>
            </div>

        </div>
        <div class="swiper-pagination"></div>
    </div>

</section><!-- End Team Section -->

<section>
    <div class="relative grid gap-8 place-items-center">
        <h1 class="text-teal-400 text-6xl font-normal" data-aos="zoom-in" data-aos-duration="1000">
            <img src="{{ asset('images/illustrations/phone-min.png') }}" class="w-12" alt="phone">
        </h1>
        <div data-aos="zoom-in" data-aos-duration="1000" class="flex flex-col sm:flex-row gap-x-2 text-md font-semibold">
            <p>+92 300 4103160</p>
            <span class="hidden sm:flex">|</span>
            <p>+92 300 0373004</p>
        </div>
        <div class="absolute h-64 w-64 sm:h-80 sm:w-80 md:w-96 md:h-96 -z-10 rounded-full bg-teal-50"></div>
    </div>
</section>

<a href="{{ url('https://wa.me/+923000373004') }}" class="flex justify-center items-center text-teal-600 text-3xl sm:text-5xl fixed right-3 bottom-3 sm:bottom-8 sm:right-8">
    <i class="bi-whatsapp"></i>
</a>
@endsection
@section('footer')
<x-footer></x-footer>
@endsection