<template>

    <div class="flex justify-between items-center">
        <h1 class="text-2xl">Product</h1>
        <router-link :to="{ name: 'app.product.new' }">
            <div class="bg-blue-600 text-white text-sm p-[0.3rem] px-2 space-x-1 cursor-pointer flex items-center">
                <span class="material-symbols-outlined">
                    add
                </span>
                <p>New Product</p>
            </div>
        </router-link>
    </div>

    <!-- <div class="bg-white mt-5">
        <div class="flex justify-between border-b-[.5px] border-black p-2">
            <div class="border-[.5px] border-gray-500 ">
                <input type="text" name="" id="" placeholder="Search" class="p-[0.2rem] px-2">
            </div>

            <div class="flex space-x-2">
                <div class="border-[.5px] border-gray-500 p-[0.2rem] cursor-pointer">
                    <select name="" id="">
                        <option value="">Category</option>
                        <option value="">Category1</option>
                        <option value="">Category2</option>
                    </select>
                </div>
                <div class="border-[.5px] border-gray-500 p-[0.2rem] flex space-x-1 cursor-pointer">
                    <p>Last added</p>
                    <span class="material-symbols-outlined text-base text-gray-600">
                        swap_vert
                    </span>
                </div>

            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 p-4 max-h-screen ">
            <ProductCard productTitle="Top notch sneaker" price=1200 sold=23 available=50 status="draft"
                image='https://ca-times.brightspotcdn.com/dims4/default/15a30ea/2147483647/strip/true/crop/6122x4081+0+1/resize/1440x960!/quality/75/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2Fb3%2F10%2F10c245034893adf233fc1cf3071a%2F1351750-fi-sneaker-buyer-coolkicks-jlc-16185-021.jpg' />
            <ProductCard productTitle="Top notch sneaker" price=1200 sold=23 available=0 status="inactive"
                image='https://ca-times.brightspotcdn.com/dims4/default/15a30ea/2147483647/strip/true/crop/6122x4081+0+1/resize/1440x960!/quality/75/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2Fb3%2F10%2F10c245034893adf233fc1cf3071a%2F1351750-fi-sneaker-buyer-coolkicks-jlc-16185-021.jpg' />
            <ProductCard productTitle="Top notch sneaker" price=1200 sold=23 available=10 status="published"
                image='https://ca-times.brightspotcdn.com/dims4/default/15a30ea/2147483647/strip/true/crop/6122x4081+0+1/resize/1440x960!/quality/75/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2Fb3%2F10%2F10c245034893adf233fc1cf3071a%2F1351750-fi-sneaker-buyer-coolkicks-jlc-16185-021.jpg' />
            <ProductCard productTitle="Top notch sneaker" price=1200 sold=23 available=50 status="scheduled"
                image='https://ca-times.brightspotcdn.com/dims4/default/15a30ea/2147483647/strip/true/crop/6122x4081+0+1/resize/1440x960!/quality/75/?url=https%3A%2F%2Fcalifornia-times-brightspot.s3.amazonaws.com%2Fb3%2F10%2F10c245034893adf233fc1cf3071a%2F1351750-fi-sneaker-buyer-coolkicks-jlc-16185-021.jpg' />


        </div>


    </div> -->
<ProductTable />

</template>

<script setup>
import ProductTable from './ProductTable.vue'
import ProductCard from '../../../components/admin/ProductCard.vue'
</script>