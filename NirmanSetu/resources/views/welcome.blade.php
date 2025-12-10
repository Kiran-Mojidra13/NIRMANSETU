<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NirmanSetu - Construction Project Management</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
</head>
<body class="antialiased text-gray-900 bg-gradient-to-b from-teal-50 to-white">

    <!-- Navbar -->
    <header x-data="{ open: false, scrolled: false }"
            x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 50)"
            :class="scrolled ? 'bg-white shadow-md' : 'bg-transparent'"
            class="fixed w-full z-50 transition duration-300">
        <nav class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="#home" class="text-2xl font-bold bg-gradient-to-r from-teal-500 to-blue-600 bg-clip-text text-transparent">
                NirmanSetu
            </a>

            <!-- Menu -->
            <div class="hidden md:flex space-x-6 items-center font-medium">
                <a href="#home" class="hover:text-teal-600">Home</a>
                <a href="#problem-solution" class="hover:text-teal-600">Problem / Solution</a>
                <a href="#features" class="hover:text-teal-600">Features</a>
                <a href="#projects" class="hover:text-teal-600">Projects</a>
                <a href="#about-us" class="hover:text-teal-600">About</a>
                <a href="#contact-us" class="hover:text-teal-600">Contact</a>

                <a href="{{ route('login') }}"
                   class="px-4 py-2 rounded-lg border border-teal-500 text-teal-600 hover:bg-teal-50 transition">
                   Login
                </a>
            </div>

            <!-- Mobile -->
            <button @click="open = !open" class="md:hidden focus:outline-none">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </nav>

        <!-- Mobile Menu -->
        <div x-show="open" @click.away="open=false" class="md:hidden bg-white shadow-md">
            <a href="#home" class="block px-6 py-3 hover:bg-teal-50">Home</a>
            <a href="#problem-solution" class="block px-6 py-3 hover:bg-teal-50">Problem / Solution</a>
            <a href="#features" class="block px-6 py-3 hover:bg-teal-50">Features</a>
            <a href="#projects" class="block px-6 py-3 hover:bg-teal-50">Projects</a>
            <a href="#about-us" class="block px-6 py-3 hover:bg-teal-50">About</a>
            <a href="#contact-us" class="block px-6 py-3 hover:bg-teal-50">Contact</a>
            <a href="{{ route('login') }}" class="block px-6 py-3 text-teal-600 font-semibold">Login</a>
        </div>
    </header>

    <!-- Hero -->
    <section id="home" class="relative h-screen flex items-center justify-center bg-cover bg-center"
             style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1920&q=80');">
        <div class="absolute inset-0 bg-gradient-to-b from-orange-300/60 border-t-orange-400"></div>
        <div class="relative z-10 text-center text-white max-w-3xl px-6">
            <h1 class="text-5xl md:text-6xl font-extrabold mb-6">
                Build Faster, <span class="bg-gradient-to-r from-orange-400 to-yellow-500 bg-clip-text text-transparent">Manage Smarter.</span>
            </h1>
            <p class="text-lg md:text-xl mb-8">Seamlessly connect Contractors and Clients with full visibility and control.</p>
            <a href="{{ route('login') }}" class="px-6 py-3 rounded-lg border border-white text-white hover:bg-white hover:text-teal-700 transition">
                Login
            </a>
        </div>
    </section>

    <!-- Problem / Solution -->
   <!-- Include Swiper CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<section id="problem-solution" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-12">Common Construction Challenges & Our Solutions</h2>

        <!-- Slider -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">

                <!-- Card 1 -->
                <div class="swiper-slide relative rounded-xl overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=800&q=80" class="w-full h-64 object-cover" alt="Communication Problem">
                    <div class="absolute inset-0 bg-black/50 p-6 flex flex-col justify-center text-white">
                        <h3 class="text-xl font-bold mb-2">Communication Breakdown 🚧</h3>
                        <p class="mb-3">Stakeholders often miss updates and critical info.</p>
                        <h4 class="font-semibold text-teal-400">Solution ✅</h4>
                        <p>Centralized chat and notifications ensure everyone stays updated.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="swiper-slide relative rounded-xl overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80" class="w-full h-64 object-cover" alt="Project Delay">
                    <div class="absolute inset-0 bg-black/50 p-6 flex flex-col justify-center text-white">
                        <h3 class="text-xl font-bold mb-2">Project Delays ⏳</h3>
                        <p class="mb-3">Lack of real-time progress updates delays timelines.</p>
                        <h4 class="font-semibold text-teal-400">Solution ✅</h4>
                        <p>Daily progress reports with photos keep projects on track.</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="swiper-slide relative rounded-xl overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/images/1.png') }}" class="w-full h-64 object-cover" alt="Client Visibility">
                    <div class="absolute inset-0 bg-black/50 p-6 flex flex-col justify-center text-white">
                        <h3 class="text-xl font-bold mb-2">Limited Client Visibility 👀</h3>
                        <p class="mb-3">Clients can’t track project progress easily.</p>
                        <h4 class="font-semibold text-teal-400">Solution ✅</h4>
                        <p>Transparent dashboards allow clients to view updates anytime.</p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="swiper-slide relative rounded-xl overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/images/2.png') }}" class="w-full h-64 object-cover" alt="Resource Management">
                    <div class="absolute inset-0 bg-black/50 p-6 flex flex-col justify-center text-white">
                        <h3 class="text-xl font-bold mb-2">Resource Mismanagement 🛠️</h3>
                        <p class="mb-3">Tools and materials are not tracked efficiently.</p>
                        <h4 class="font-semibold text-teal-400">Solution ✅</h4>
                        <p>Inventory tracking and alerts help manage resources smartly.</p>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="swiper-slide relative rounded-xl overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/images/3.png') }}" class="w-full h-64 object-cover" alt="Worker Productivity">
                    <div class="absolute inset-0 bg-black/50 p-6 flex flex-col justify-center text-white">
                        <h3 class="text-xl font-bold mb-2">Low Worker Productivity ⚡</h3>
                        <p class="mb-3">Tasks are not monitored properly, causing delays.</p>
                        <h4 class="font-semibold text-teal-400">Solution ✅</h4>
                        <p>Task assignment and tracking features boost productivity.</p>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="swiper-slide relative rounded-xl overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/images/4.png') }}" class="w-full h-64 object-cover" alt="Quality Issues">
                    <div class="absolute inset-0 bg-black/50 p-6 flex flex-col justify-center text-white">
                        <h3 class="text-xl font-bold mb-2">Quality Issues 🔧</h3>
                        <p class="mb-3">Construction work sometimes fails quality standards.</p>
                        <h4 class="font-semibold text-teal-400">Solution ✅</h4>
                        <p>Regular quality audits and reporting ensure high standards.</p>
                    </div>
                </div>

                <!-- Card 7 -->
                <div class="swiper-slide relative rounded-xl overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/images/5.png') }}" class="w-full h-64 object-cover" alt="Budget Overruns">
                    <div class="absolute inset-0 bg-black/50 p-6 flex flex-col justify-center text-white">
                        <h3 class="text-xl font-bold mb-2">Budget Overruns 💸</h3>
                        <p class="mb-3">Costs often exceed estimates due to poor tracking.</p>
                        <h4 class="font-semibold text-teal-400">Solution ✅</h4>
                        <p>Expense tracking with alerts helps keep budgets under control.</p>
                    </div>
                </div>

                <!-- Card 8 -->
                <div class="swiper-slide relative rounded-xl overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/images/6.png') }}" class="w-full h-64 object-cover" alt="Schedule Conflicts">
                    <div class="absolute inset-0 bg-black/50 p-6 flex flex-col justify-center text-white">
                        <h3 class="text-xl font-bold mb-2">Schedule Conflicts 🗓️</h3>
                        <p class="mb-3">Multiple tasks overlap, delaying delivery.</p>
                        <h4 class="font-semibold text-teal-400">Solution ✅</h4>
                        <p>Integrated scheduling and calendar tools prevent conflicts.</p>
                    </div>
                </div>

                <!-- Card 9 -->
                <div class="swiper-slide relative rounded-xl overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/images/7.png') }}" class="w-full h-64 object-cover" alt="Document Management">
                    <div class="absolute inset-0 bg-black/50 p-6 flex flex-col justify-center text-white">
                        <h3 class="text-xl font-bold mb-2">Document Chaos 📄</h3>
                        <p class="mb-3">Project documents are scattered and hard to access.</p>
                        <h4 class="font-semibold text-teal-400">Solution ✅</h4>
                        <p>Centralized document management ensures quick access.</p>
                    </div>
                </div>

                <!-- Card 10 -->
                <div class="swiper-slide relative rounded-xl overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/images/8.png') }}" class="w-full h-64 object-cover" alt="Safety Issues">
                    <div class="absolute inset-0 bg-black/50 p-6 flex flex-col justify-center text-white">
                        <h3 class="text-xl font-bold mb-2">Safety Issues ⚠️</h3>
                        <p class="mb-3">Unsafe practices can cause accidents on site.</p>
                        <h4 class="font-semibold text-teal-400">Solution ✅</h4>
                        <p>Monitoring tools and safety protocols reduce risks.</p>
                    </div>
                </div>

            </div>
            <!-- Pagination -->
            <div class="swiper-pagination mt-6"></div>
        </div>
    </div>

    <!-- Swiper Initialization -->
    <script>
        const swiper = new Swiper('.mySwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 3000, // Change slide every 3 seconds
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
            },
        });
    </script>
</section>


    <!-- Features -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <section id="features" class="py-20 bg-gradient-to-b from-teal-50 to-white">
    <div x-data="{ openModal: '' }" class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">One Platform. Two Powerful Experiences.</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

            <!-- Contractor Card -->
            <div class="p-6 rounded-xl shadow-lg transition transform hover:scale-105 border bg-white relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-teal-100 to-teal-200 opacity-50"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <img src="https://img.icons8.com/ios-filled/50/000000/worker-male.png" class="mb-4 mx-auto"/>
                    <h3 class="text-xl font-semibold mb-4 text-center">Contractor Panel</h3>
                    <ul class="space-y-2 text-gray-700 mb-4">
                        <li class="flex items-center"><span class="mr-2 text-teal-500">➡️</span> Assign tasks and track workers</li>
                        <li class="flex items-center"><span class="mr-2 text-teal-500">➡️</span> Upload daily site updates</li>
                        <li class="flex items-center"><span class="mr-2 text-teal-500">➡️</span> Easy invoicing & billing</li>
                    </ul>
                    <button @click="openModal = 'contractor'" class="mt-auto px-4 py-2 bg-teal-500 text-white rounded hover:bg-teal-600">Learn More</button>
                </div>
            </div>

            <!-- Client Card -->
            <div class="p-6 rounded-xl shadow-lg transition transform hover:scale-105 border bg-white relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-100 to-blue-200 opacity-50"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <img src="https://img.icons8.com/ios-filled/50/000000/meeting.png" class="mb-4 mx-auto"/>
                    <h3 class="text-xl font-semibold mb-4 text-center">Client Portal</h3>
                    <ul class="space-y-2 text-gray-700 mb-4">
                        <li class="flex items-center"><span class="mr-2 text-blue-500">➡️</span> Real-time project tracking</li>
                        <li class="flex items-center"><span class="mr-2 text-blue-500">➡️</span> Transparent communication</li>
                        <li class="flex items-center"><span class="mr-2 text-blue-500">➡️</span> Review bills & approve work</li>
                    </ul>
                    <button @click="openModal = 'client'" class="mt-auto px-4 py-2 bg-teal-500 text-white rounded hover:bg-teal-600">Learn More</button>
                </div>
            </div>

            <!-- Management Card -->
            <div class="p-6 rounded-xl shadow-lg transition transform hover:scale-105 border bg-gradient-to-r from-teal-500 to-blue-600 text-white relative overflow-hidden">
                <img src="https://img.icons8.com/ios-filled/50/ffffff/management.png" class="mb-4 mx-auto"/>
                <h3 class="text-xl font-semibold mb-4 text-center">Strong Management</h3>
                <ul class="space-y-2 mb-4">
                    <li class="flex items-center"><span class="mr-2 text-white">➡️</span> Centralized data & analytics</li>
                    <li class="flex items-center"><span class="mr-2 text-white">➡️</span> Role-based access control</li>
                    <li class="flex items-center"><span class="mr-2 text-white">➡️</span> 24/7 monitoring & support</li>
                </ul>
                <button @click="openModal = 'management'" class="mt-auto px-4 py-2 bg-teal-500 text-white rounded hover:bg-teal-600">Learn More</button>
            </div>

            <!-- Analytics Card -->
            <div class="p-6 rounded-xl shadow-lg transition transform hover:scale-105 border bg-white relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-100 to-purple-200 opacity-50"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <img src="https://img.icons8.com/ios-filled/50/000000/combo-chart--v1.png" class="mb-4 mx-auto"/>
                    <h3 class="text-xl font-semibold mb-4 text-center">Analytics Panel</h3>
                    <ul class="space-y-2 text-gray-700 mb-4">
                        <li class="flex items-center"><span class="mr-2 text-purple-500">➡️</span> Real-time dashboards</li>
                        <li class="flex items-center"><span class="mr-2 text-purple-500">➡️</span> Track project metrics</li>
                        <li class="flex items-center"><span class="mr-2 text-purple-500">➡️</span> Export detailed reports</li>
                    </ul>
                    <button @click="openModal = 'analytics'" class="mt-auto px-4 py-2 bg-teal-500 text-white rounded hover:bg-teal-600">Learn More</button>
                </div>
            </div>

        </div>

        <!-- Modal -->
        <div
            x-show="openModal"
            x-transition.opacity
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        >
            <div
                @click.away="openModal = ''"
                x-transition
                class="bg-white rounded-lg shadow-lg max-w-xl w-full p-6 relative"
            >
                <button @click="openModal=''" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>

                <!-- Contractor Modal -->
                <template x-if="openModal === 'contractor'">
                    <div class="space-y-4">
                        <img src="https://img.icons8.com/color/96/000000/construction-worker.png" class="mx-auto"/>
                        <h3 class="text-2xl font-bold mb-2 text-center">Contractor Panel Details</h3>
                        <p>Contractors can efficiently manage construction tasks including:</p>
                        <ul class="list-disc list-inside space-y-1 text-gray-700">
                            <li>Plan passing and site approvals</li>
                            <li>Task assignments to workers</li>
                            <li>Daily progress updates with photos</li>
                            <li>Billing and invoicing management</li>
                            <li>Material tracking and inventory</li>
                        </ul>
                        <img src="https://img.icons8.com/color/96/000000/blueprint.png" class="mx-auto"/>
                    </div>
                </template>

                <!-- Client Modal -->
                <template x-if="openModal === 'client'">
                    <div class="space-y-4">
                        <img src="https://img.icons8.com/color/96/000000/client.png" class="mx-auto"/>
                        <h3 class="text-2xl font-bold mb-2 text-center">Client Portal Details</h3>
                        <p>Clients can:</p>
                        <ul class="list-disc list-inside space-y-1 text-gray-700">
                            <li>Track real-time project updates</li>
                            <li>Review bills and approve payments</li>
                            <li>Communicate directly with contractors and management</li>
                            <li>Access photos and reports of ongoing work</li>
                            <li>Monitor multiple projects easily</li>
                        </ul>
                        <img src="https://img.icons8.com/color/96/000000/report-card.png" class="mx-auto"/>
                    </div>
                </template>

                <!-- Management Modal -->
                <template x-if="openModal === 'management'">
                    <div class="space-y-4">
                        <img src="https://img.icons8.com/color/96/000000/manager.png" class="mx-auto"/>
                        <h3 class="text-2xl font-bold mb-2 text-center">Management Panel Details</h3>
                        <p>Management features include:</p>
                        <ul class="list-disc list-inside space-y-1 text-gray-700">
                            <li>Centralized data control</li>
                            <li>Role-based access for all users</li>
                            <li>24/7 monitoring of projects</li>
                            <li>Analytics and reporting dashboards</li>
                            <li>Team coordination and support</li>
                        </ul>
                        <img src="https://img.icons8.com/color/96/000000/organization.png" class="mx-auto"/>
                    </div>
                </template>

                <!-- Analytics Modal -->
                <template x-if="openModal === 'analytics'">
                    <div class="space-y-4">
                        <img src="https://img.icons8.com/color/96/000000/combo-chart.png" class="mx-auto"/>
                        <h3 class="text-2xl font-bold mb-2 text-center">Analytics Panel Details</h3>
                        <p>The analytics panel provides:</p>
                        <ul class="list-disc list-inside space-y-1 text-gray-700">
                            <li>Real-time dashboards for all projects</li>
                            <li>Track project progress and metrics</li>
                            <li>Export detailed reports for planning</li>
                            <li>Monitor timelines, costs, and efficiency</li>
                        </ul>
                        <img src="https://img.icons8.com/color/96/000000/data.png" class="mx-auto"/>
                    </div>
                </template>

                <div class="mt-6 text-center">
                    <button @click="openModal=''" class="px-4 py-2 bg-teal-500 text-white rounded hover:bg-teal-600">Close</button>
                </div>
            </div>
        </div>
    </div>
</section>





    <!-- Projects / Gallery -->
    @php
$projects = DB::select('SELECT * FROM projects ORDER BY created_at DESC');
@endphp

<section id="projects" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-12">Our Recent Projects 🏗️</h2>

        <div class="grid md:grid-cols-3 gap-8">
            @foreach($projects as $project)
                @php
                    $images = json_decode($project->image_url) ?? [];
                    $cover = $images[0] ?? 'https://via.placeholder.com/400x250?text=No+Image';
                @endphp

                <div x-data="{ open: false }" class="rounded-xl overflow-hidden shadow hover:shadow-lg transition cursor-pointer">
                    <img src="{{ $cover }}" class="w-full h-56 object-cover" alt="{{ $project->name }}" @click="open = true">
                    <div class="p-4" @click="open = true">
                        <h3 class="font-semibold text-lg">{{ $project->name }}</h3>
                        <p class="text-gray-600 text-sm">{{ $project->description }}</p>
                    </div>

                    <!-- Modal -->
                    <div x-show="open" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-xl shadow-lg w-11/12 md:w-3/4 max-h-[90vh] overflow-y-auto p-6 relative">
                            <button @click="open = false" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-xl font-bold">&times;</button>

                            <h2 class="text-2xl font-bold mb-4">{{ $project->name }}</h2>
                            <p class="mb-2"><strong>Description:</strong> {{ $project->description }}</p>
                            <p class="mb-4"><strong>Location:</strong> {{ $project->location }}</p>

                            @if(count($images) > 0)
                                <div class="grid gap-4 @if(count($images) > 9) swiper @else grid-cols-1 md:grid-cols-3 @endif">
                                    @foreach($images as $img)
                                        <img src="{{ $img }}" class="w-full h-40 object-cover rounded" alt="Project Image">
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 italic">No images available for this project.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Optional: Include SwiperJS if you want slider for >9 images -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('sliderInit', () => ({
            init() {
                if (document.querySelectorAll('.swiper').length) {
                    new Swiper('.swiper', {
                        slidesPerView: 3,
                        spaceBetween: 10,
                        navigation: true,
                        loop: true,
                    });
                }
            }
        }))
    })
</script>

<!--achievement-->
<!-- Include Alpine.js v3 (if not already included) -->
<!-- Include Alpine.js v3 -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<section id="achievements" class="py-20 bg-gradient-to-r from-teal-50 to-white">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-12">Our Achievements 🏆</h2>

        <div class="grid md:grid-cols-3 gap-12">
            <!-- Projects Completed -->
            <div x-data="{ count: 0, target: 50, triggered: false }"
                 x-init="
                    window.addEventListener('scroll', () => {
                        const el = $el.getBoundingClientRect();
                        if(!triggered && el.top < window.innerHeight){
                            triggered = true;
                            let interval = setInterval(() => {
                                if(count < target){ count += 1; }
                                else{ count = target; clearInterval(interval); }
                            }, 20);
                        }
                    });
                 "
                 class="p-8 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-2">
                <div class="text-5xl mb-4 font-bold text-teal-600">🏗️ <span x-text="count">0</span>+</div>
                <p class="text-lg font-semibold text-gray-700">Projects Completed</p>
            </div>

            <!-- Engineers & Contractors -->
            <div x-data="{ count: 0, target: 15, triggered: false }"
                 x-init="
                    window.addEventListener('scroll', () => {
                        const el = $el.getBoundingClientRect();
                        if(!triggered && el.top < window.innerHeight){
                            triggered = true;
                            let interval = setInterval(() => {
                                if(count < target){ count += 1; }
                                else{ count = target; clearInterval(interval); }
                            }, 50);
                        }
                    });
                 "
                 class="p-8 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-2">
                <div class="text-5xl mb-4 font-bold text-teal-600">👷 <span x-text="count">0</span>+</div>
                <p class="text-lg font-semibold text-gray-700">Engineers & Contractors</p>
            </div>

            <!-- Client Satisfaction -->
            <div x-data="{ count: 0, target: 100, triggered: false }"
                 x-init="
                    window.addEventListener('scroll', () => {
                        const el = $el.getBoundingClientRect();
                        if(!triggered && el.top < window.innerHeight){
                            triggered = true;
                            let interval = setInterval(() => {
                                if(count < target){ count += 1; }
                                else{ count = target; clearInterval(interval); }
                            }, 15);
                        }
                    });
                 "
                 class="p-8 bg-white rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-2">
                <div class="text-5xl mb-4 font-bold text-teal-600">📈 <span x-text="count">0</span>%</div>
                <p class="text-lg font-semibold text-gray-700">Client Satisfaction</p>
            </div>
        </div>
    </div>
</section>







    <!-- About Us -->
    <section id="about-us" class="py-20 bg-gradient-to-b from-teal-50 to-white">
    <div class="max-w-5xl mx-auto text-center px-6">
        <h2 class="text-4xl font-bold mb-6 transition-transform duration-700 ease-in-out transform hover:scale-105">About NirmanSetu 🏢</h2>
        <p class="text-lg text-gray-700 mb-8 transition-opacity duration-1000 opacity-80 hover:opacity-100">
            At <span class="font-semibold text-teal-600">NirmanSetu</span>, we bridge the gap between contractors and clients by
            delivering a unified project management platform designed for the construction industry.
            Our mission is to make construction faster, smarter, and more transparent — one project at a time.
        </p>

        <!-- Core Values -->
        <div class="grid md:grid-cols-3 gap-8 mt-12">
            <div class="p-6 rounded-xl shadow bg-white transition-transform duration-500 hover:-translate-y-2 hover:shadow-lg">
                <h3 class="font-semibold text-xl mb-2">🚀 Mission</h3>
                <p class="text-gray-600">Empower teams to deliver successful construction projects with collaboration and clarity.</p>
            </div>
            <div class="p-6 rounded-xl shadow bg-white transition-transform duration-500 hover:-translate-y-2 hover:shadow-lg">
                <h3 class="font-semibold text-xl mb-2">🌟 Vision</h3>
                <p class="text-gray-600">To be the leading platform transforming construction project workflows globally.</p>
            </div>
            <div class="p-6 rounded-xl shadow bg-white transition-transform duration-500 hover:-translate-y-2 hover:shadow-lg">
                <h3 class="font-semibold text-xl mb-2">🤝 Our Team</h3>
                <p class="text-gray-600">A passionate group of engineers, designers, and construction experts committed to innovation.</p>
            </div>
        </div>

        <!-- Trust & Reliability Section -->
        <div class="mt-16 space-y-6 text-left">
            <h3 class="text-3xl font-bold mb-4 text-teal-600 transition-transform duration-700 hover:scale-105">Why Clients Trust Us</h3>
            <p class="text-gray-700 text-lg transition-opacity duration-1000 opacity-80 hover:opacity-100">
                ✅ <span class="font-semibold">Proven Track Record:</span> Successfully delivered 50+ projects across residential, commercial, and infrastructure sectors.
            </p>
            <p class="text-gray-700 text-lg transition-opacity duration-1000 opacity-80 hover:opacity-100">
                ✅ <span class="font-semibold">Certified Partners:</span> Collaborating only with verified contractors and engineers to ensure quality and safety.
            </p>
            <p class="text-gray-700 text-lg transition-opacity duration-1000 opacity-80 hover:opacity-100">
                ✅ <span class="font-semibold">Transparent Processes:</span> Real-time project tracking and documentation that builds confidence and accountability.
            </p>
            <p class="text-gray-700 text-lg transition-opacity duration-1000 opacity-80 hover:opacity-100">
                ✅ <span class="font-semibold">Client Satisfaction:</span> Our top priority is delivering projects on time, within budget, and exceeding expectations.
            </p>
            <p class="text-gray-700 text-lg transition-opacity duration-1000 opacity-80 hover:opacity-100">
                ✅ <span class="font-semibold">Cutting-edge Technology:</span> Leveraging modern tools to ensure smarter planning, monitoring, and execution.
            </p>
        </div>

        <!-- Optional: Testimonials / Small Quotes -->
        <div class="mt-16 grid md:grid-cols-2 gap-8">
            <div class="p-6 rounded-xl shadow bg-white transition-transform duration-500 hover:-translate-y-2 hover:shadow-lg">
                <p class="text-gray-700 italic">"NirmanSetu made managing our construction projects seamless and transparent. Highly recommended!"</p>
                <h4 class="mt-3 font-semibold text-teal-600">— Urban Projects Ltd.</h4>
            </div>
            <div class="p-6 rounded-xl shadow bg-white transition-transform duration-500 hover:-translate-y-2 hover:shadow-lg">
                <p class="text-gray-700 italic">"Their platform helped us stay on schedule and communicate effectively with all contractors."</p>
                <h4 class="mt-3 font-semibold text-teal-600">— ABC Builders</h4>
            </div>
        </div>
    </div>
</section>




<!--work flow-->
<section id="workflow" class="py-20 bg-gradient-to-b from-white to-teal-50">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-12 transition-transform duration-700 ease-in-out transform hover:scale-105">
            How It Works 🔧
        </h2>
        <p class="text-lg text-gray-700 mb-16">
            Streamline your construction projects with NirmanSetu — from client submission to project delivery.
        </p>

        <!-- Workflow Steps -->
        <div class="flex flex-col md:flex-row items-center justify-between relative">
            <!-- Step 1: Client Submits Project -->
            <div x-data="{ visible: false }"
                 x-init="window.addEventListener('scroll', () => {
                    const el = $el.getBoundingClientRect();
                    if(!visible && el.top < window.innerHeight){ visible = true; }
                 })"
                 :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                 class="flex-1 p-6 text-center transition-all duration-700">
                <div class="mx-auto w-20 h-20 rounded-full bg-teal-600 text-white text-2xl flex items-center justify-center font-bold mb-4">
                    1
                </div>
                <h3 class="text-xl font-semibold mb-2">Client Submits Project</h3>
                <p class="text-gray-600">
                    The client submits project details, requirements, and location to the admin for review.
                </p>
            </div>

            <!-- Arrow -->
            <div class="hidden md:block w-12 h-1 bg-teal-300 rotate-0 mt-10"></div>

            <!-- Step 2: Admin Assigns Engineer -->
            <div x-data="{ visible: false }"
                 x-init="window.addEventListener('scroll', () => {
                    const el = $el.getBoundingClientRect();
                    if(!visible && el.top < window.innerHeight){ visible = true; }
                 })"
                 :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                 class="flex-1 p-6 text-center transition-all duration-700 delay-200">
                <div class="mx-auto w-20 h-20 rounded-full bg-teal-600 text-white text-2xl flex items-center justify-center font-bold mb-4">
                    2
                </div>
                <h3 class="text-xl font-semibold mb-2">Admin Assigns Engineer</h3>
                <p class="text-gray-600">
                    Admin reviews the project and assigns it to the relevant engineer or contractor with specific tasks.
                </p>
            </div>

            <!-- Arrow -->
            <div class="hidden md:block w-12 h-1 bg-teal-300 rotate-0 mt-10"></div>

            <!-- Step 3: Engineer Works & Uploads -->
            <div x-data="{ visible: false }"
                 x-init="window.addEventListener('scroll', () => {
                    const el = $el.getBoundingClientRect();
                    if(!visible && el.top < window.innerHeight){ visible = true; }
                 })"
                 :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                 class="flex-1 p-6 text-center transition-all duration-700 delay-400">
                <div class="mx-auto w-20 h-20 rounded-full bg-teal-600 text-white text-2xl flex items-center justify-center font-bold mb-4">
                    3
                </div>
                <h3 class="text-xl font-semibold mb-2">Engineer Works & Uploads</h3>
                <p class="text-gray-600">
                    Engineer completes assigned tasks, uploads site images, and updates progress for admin review.
                </p>
            </div>

            <!-- Arrow -->
            <div class="hidden md:block w-12 h-1 bg-teal-300 rotate-0 mt-10"></div>

            <!-- Step 4: Delivery & Client Review -->
            <div x-data="{ visible: false }"
                 x-init="window.addEventListener('scroll', () => {
                    const el = $el.getBoundingClientRect();
                    if(!visible && el.top < window.innerHeight){ visible = true; }
                 })"
                 :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                 class="flex-1 p-6 text-center transition-all duration-700 delay-600">
                <div class="mx-auto w-20 h-20 rounded-full bg-teal-600 text-white text-2xl flex items-center justify-center font-bold mb-4">
                    4
                </div>
                <h3 class="text-xl font-semibold mb-2">Delivery & Client Review</h3>
                <p class="text-gray-600">
                    Admin finalizes the project and delivers it to the client, who can review progress and approve completion.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <!-- Contact -->
    <section id="contact-us" class="relative py-20 text-white text-center overflow-hidden">
    <!-- Animated Gradient Background -->
    <div class="absolute inset-0 bg-gradient-to-r from-teal-600 to-blue-700 animate-gradient-background -z-10"></div>
    <div class="absolute inset-0 opacity-30 bg-[url('https://images.unsplash.com/photo-1508780709619-79562169bc64?auto=format&fit=crop&w=1470&q=80')] bg-cover bg-center animate-clouds -z-20"></div>

    <div class="relative z-10 max-w-3xl mx-auto px-6">
        <h2 class="text-4xl font-bold mb-6 transition-transform duration-700 ease-in-out transform hover:scale-105">
            Ready to Transform Your Construction Management?
        </h2>
        <p class="mb-8 text-lg transition-opacity duration-1000 opacity-80 hover:opacity-100">
            Contact us today to learn more or get started with your project.
        </p>

        <!-- Contact Details -->
        <div class="mb-8 space-y-3 text-left">
            <p class="text-lg"><strong>📧 Email:</strong> <a href="mailto:support@nirmanSetu.com" class="underline hover:text-teal-300">support@nirmanSetu.com</a></p>
            <p class="text-lg"><strong>📞 Phone:</strong> <a href="tel:+911234567890" class="underline hover:text-teal-300">+91 123 456 7890</a></p>
            <p class="text-lg"><strong>📍 Address:</strong> 123 Construction Street, Ahmedabad, India</p>
        </div>

        <!-- Buttons -->
        <div class="flex flex-col md:flex-row justify-center gap-4">
            <a href="{{ route('login') }}"
               class="px-6 py-3 rounded-lg border border-white text-white hover:bg-white hover:text-teal-700 transition">
               Login
            </a>
            <a href="mailto:support@nirmanSetu.com"
               class="px-6 py-3 rounded-lg border border-white text-white hover:bg-white hover:text-teal-700 transition">
               Email Us
            </a>
        </div>
    </div>
</section>

<!-- Custom CSS for animation -->
<style>
    /* Gradient moving background */
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .animate-gradient-background {
        background: linear-gradient(270deg, #14b8a6, #3b82f6, #06b6d4);
        background-size: 600% 600%;
        animation: gradientShift 15s ease infinite;
    }

    /* Clouds/smoke overlay animation */
    @keyframes cloudMove {
        0% { background-position: 0 0; }
        100% { background-position: -2000px 0; }
    }

    .animate-clouds {
        animation: cloudMove 120s linear infinite;
    }
</style>


   <!-- Footer -->
<!-- Footer -->
<footer class="py-12 bg-gradient-to-r from-yellow-50 via-white to-yellow-100 text-gray-700">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-8">

        <!-- Brand + Quote -->
        <div>
            <h2 class="text-2xl font-bold text-teal-700 mb-3">🏗️ NirmanSetu</h2>
            <p class="text-sm italic text-gray-600">
                "Building trust, one project at a time — where transparency meets construction excellence."
            </p>
        </div>

        <!-- Quick Links -->
        <div>
            <h3 class="font-semibold text-lg text-teal-700 mb-3">Quick Links</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="#about-us" class="hover:text-teal-600 transition">About Us</a></li>
                <li><a href="#features" class="hover:text-teal-600 transition">Features</a></li>
                <li><a href="#workflow" class="hover:text-teal-600 transition">How It Works</a></li>
                <li><a href="#contact-us" class="hover:text-teal-600 transition">Contact</a></li>
            </ul>
        </div>

        <!-- Contact Info -->
        <div>
            <h3 class="font-semibold text-lg text-teal-700 mb-3">Contact Us</h3>
            <ul class="text-sm space-y-2">
                <li>📍 123 Construction Street, Ahmedabad, Gujarat, India</li>
                <li>📞 +91 98765 43210</li>
                <li>✉️
                    <a href="mailto:info@nirmanSetu.com" class="hover:text-teal-600 transition">
                        info@nirmanSetu.com
                    </a>
                </li>
            </ul>
        </div>

        <!-- Social Media -->
        <div>
            <h3 class="font-semibold text-lg text-teal-700 mb-3">Follow Us</h3>
            <div class="flex space-x-4 text-xl">
                <a href="#" class="hover:text-teal-600 transition"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="hover:text-teal-600 transition"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-teal-600 transition"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" class="hover:text-teal-600 transition"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>

    <!-- Bottom Line -->
    <div class="border-t border-gray-300 mt-8 pt-4 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} <span class="font-semibold text-teal-700">NirmanSetu</span>. All rights reserved.
    </div>
</footer>

<!-- FontAwesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">



</body>
</html>
