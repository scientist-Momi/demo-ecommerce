<template>

    <!-- down -->
    <div class="flex flex-col lg:flex-row space-x-4 mt-10">
        <!-- orders -->
        <div class="bg-white lg:w-[65%] w-full max-h-screen lg:max-h-[470px] overflow-auto">
            <div class="border-bottom border-black flex justify-between p-2 items-center">
                <div class="">
                    <h2>Latest Orders</h2>
                </div>
                <router-link :to="{ name: 'app.order' }">
                    <div class="bg-blue-600 text-white text-sm p-[0.3rem] px-3 cursor-pointer">
                        View All
                    </div>
                </router-link>
            </div>
            <div class="bg-red-300">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Product name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Color
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Price
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Apple MacBook Pro 17"
                                </th>
                                <td class="px-6 py-4">
                                    Silver
                                </td>
                                <td class="px-6 py-4">
                                    Laptop
                                </td>
                                <td class="px-6 py-4">
                                    $2999
                                </td>
                            </tr>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Microsoft Surface Pro
                                </th>
                                <td class="px-6 py-4">
                                    White
                                </td>
                                <td class="px-6 py-4">
                                    Laptop PC
                                </td>
                                <td class="px-6 py-4">
                                    $1999
                                </td>
                            </tr>
                            <tr class="bg-white dark:bg-gray-800">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Magic Mouse 2
                                </th>
                                <td class="px-6 py-4">
                                    Black
                                </td>
                                <td class="px-6 py-4">
                                    Accessories
                                </td>
                                <td class="px-6 py-4">
                                    $99
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- Stats -->
        <div class="w-[35%] max-h-screen lg:max-h-[470px] overflow-auto">
            <div class="bg-white pb-2">
                <div class="border-b-[.5px] border-black flex p-2">
                    <h2>Most selling product</h2>
                </div>
                <div class="flex m-3 justify-between">
                    <img src="https://ca-times.brightspotcdn.com/dims4/default/15a30ea/2147483647/strip/true/crop/6122x4081+0+1/resize/1440x960!/quality/75/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2Fb3%2F10%2F10c245034893adf233fc1cf3071a%2F1351750-fi-sneaker-buyer-coolkicks-jlc-16185-021.jpg"
                        alt="" class="h-14">
                    <div>
                        <p>High boost sneaker</p>
                        <p>180 sales</p>
                    </div>
                    <div>
                        <p>£120,000</p>
                    </div>
                </div>
                <div class="flex m-3 justify-between">
                    <img src="https://ca-times.brightspotcdn.com/dims4/default/15a30ea/2147483647/strip/true/crop/6122x4081+0+1/resize/1440x960!/quality/75/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2Fb3%2F10%2F10c245034893adf233fc1cf3071a%2F1351750-fi-sneaker-buyer-coolkicks-jlc-16185-021.jpg"
                        alt="" class="h-14">
                    <div>
                        <p>High boost sneaker</p>
                        <p>180 sales</p>
                    </div>
                    <div>
                        <p>£120,000</p>
                    </div>
                </div>
                <div class="flex m-3 justify-between">
                    <img src="https://ca-times.brightspotcdn.com/dims4/default/15a30ea/2147483647/strip/true/crop/6122x4081+0+1/resize/1440x960!/quality/75/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2Fb3%2F10%2F10c245034893adf233fc1cf3071a%2F1351750-fi-sneaker-buyer-coolkicks-jlc-16185-021.jpg"
                        alt="" class="h-14">
                    <div>
                        <p>High boost sneaker</p>
                        <p>180 sales</p>
                    </div>
                    <div>
                        <p>£120,000</p>
                    </div>
                </div>
            </div>

            <!-- Top Customers -->
            <div class="bg-white mt-5">
                <div class="border-b-[.5px] border-black flex p-2">
                    <h2>Top Customers</h2>
                </div>
                <div class="flex m-3 justify-between">
                    <img src="https://ca-times.brightspotcdn.com/dims4/default/15a30ea/2147483647/strip/true/crop/6122x4081+0+1/resize/1440x960!/quality/75/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2Fb3%2F10%2F10c245034893adf233fc1cf3071a%2F1351750-fi-sneaker-buyer-coolkicks-jlc-16185-021.jpg"
                        alt="" class="h-14">
                    <div>
                        <p>High boost sneaker</p>
                        <p>180 sales</p>
                    </div>
                    <div>
                        <p>£120,000</p>
                    </div>
                </div>
                <div class="flex m-3 justify-between">
                    <img src="https://ca-times.brightspotcdn.com/dims4/default/15a30ea/2147483647/strip/true/crop/6122x4081+0+1/resize/1440x960!/quality/75/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2Fb3%2F10%2F10c245034893adf233fc1cf3071a%2F1351750-fi-sneaker-buyer-coolkicks-jlc-16185-021.jpg"
                        alt="" class="h-14">
                    <div>
                        <p>High boost sneaker</p>
                        <p>180 sales</p>
                    </div>
                    <div>
                        <p>£120,000</p>
                    </div>
                </div>
                <div class="flex m-3 justify-between">
                    <img src="https://ca-times.brightspotcdn.com/dims4/default/15a30ea/2147483647/strip/true/crop/6122x4081+0+1/resize/1440x960!/quality/75/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2Fb3%2F10%2F10c245034893adf233fc1cf3071a%2F1351750-fi-sneaker-buyer-coolkicks-jlc-16185-021.jpg"
                        alt="" class="h-14">
                    <div>
                        <p>High boost sneaker</p>
                        <p>180 sales</p>
                    </div>
                    <div>
                        <p>£120,000</p>
                    </div>
                </div>
            </div>


        </div>
    </div>
</template>