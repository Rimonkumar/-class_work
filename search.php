<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hunting Phone Api</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <header>
        <h2 class="text-6xl">Hunting Phone</h2>

    </header>
    <main class="container mx-auto mt-8">
        <section class="bg-gray-100 p-4 m-4">
            <!-- <input id="search-field"
            type="text"
            placeholder="search"
            class="input input-bordered input-secondary w-full max-w-xs" />
            <button onclick="handelSearch()" class="btn btn-active btn-accent">Search</button> -->

            <!-- search field2 -->
            <input id="search-field2" type="text" placeholder="Type here"
                class="input input-bordered input-secondary w-full max-w-xs" />
                <button onclick="handelSearch2(false)" class="btn btn-primary">Search</button>


        </section>



        <section class="container mx-auto mt-8">
            <div id="loading-spinner" class="text-center my-40 hidden">
                <span class="loading loading-spinner loading-lg"></span>
            </div>

            <div id="phone-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            </div>
            <!-- show all button -->
            <div id="show-all-button" class="hidden text-center my-8 ">
                <button onclick="handelShowAll()" class="btn btn-primary ">Show All </button>
            </div>
        </section>
        <section>
            <!-- Open the modal using ID.showModal() method -->

            <!-- <button onclick="haldelShowDetail('${phons.slug}'); document.getElementById('show-deatil-model').showModal()" class="btn btn-primary">Show Details</button> -->

        
            <dialog id="show-deatil-model" class="modal">
                <div class="modal-box">
                    <h3 id="phone-name" class="text-lg font-bold"></h3>
                   <div id="show-details-contaier">

                   </div>
                    
                    <div class="modal-action">
                        <form method="dialog">
                            <!-- if there is a button in form, it will close the modal -->
                            <button class="btn">Close</button>
                        </form>
                    </div>
                </div>
            </dialog>
        </section>

    </main>
    <footer>

    </footer>
    <script src="js/phone.js"></script>

</body>

</html>