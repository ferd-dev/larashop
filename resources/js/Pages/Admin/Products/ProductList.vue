<script setup>
import { ref } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import { Plus } from '@element-plus/icons-vue'
import ProductTable from './ProductTable.vue';
import Pagination from './Pagination.vue';
import ProductSearch from "./ProductSearch.vue";

defineProps({
    products: Object
})

// const products = usePage().props.products.data;
const brands = usePage().props.brands;
const categories = usePage().props.categories;

const isAddModalOpen = ref(false);
const dialogVisible = ref(false)
const editMode = ref(false)

const product = ref({
    id: null,
    title: "",
    categoryId: "",
    brandId: "",
    quantity: 0,
    description: "",
    inStock: false,
    published: false,
    price: 0,
    productImages: [],
});

const productImages = ref([]);
const dialogImageUrl = ref("");
const dialogImageVisible = ref(false);

const handleFileChange = (file) => {
    productImages.value.push(file);
};

const handlePictureCardPreview = (file) => {
    dialogImageUrl.value = file.url
    dialogImageVisible.value = true
}

const handleRemove = (file) => {
  console.log(file)
}

const openAddModal = () => {
    resetFormValues();
    isAddModalOpen.value = true;
    dialogVisible.value = true
    editMode.value = false
};

const addProdcut = async () => {
    const formData = new FormData();
    formData.append("title", product.value.title);
    formData.append("category_id", product.value.categoryId);
    formData.append("brand_id", product.value.brandId);
    formData.append("quantity", product.value.quantity);
    formData.append("description", product.value.description);
    formData.append("price", product.value.price);

    for (const image of productImages.value) {
        formData.append("product_images[]", image.raw);
    }

    try {
        await router.post("products/store", formData, {
            onSuccess: (page) => {
                isAddModalOpen.value = false;
                dialogVisible.value = false
                resetFormValues();

                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "success",
                    showConfirmButton: false,
                    title: page.props.flash.success,
                    timer: 3000,
                    timerProgressBar: true,
                });
            },
        });
    } catch (error) {
        console.error("Error uploading images:", error);
    }
};

const resetFormValues = () => {
    product.value = {
        id: null,
        title: "",
        categoryId: "",
        brandId: "",
        quantity: 0,
        description: "",
        inStock: false,
        published: false,
        price: 0,
    };

    productImages.value = [];

    dialogImageUrl.value = "";
};

const openEditModal = (productValue) => {
    editMode.value = true
    isAddModalOpen.value = false;
    dialogVisible.value = true

    product.value.id = productValue.id;
    product.value.title = productValue.title;
    product.value.categoryId = productValue.category_id;
    product.value.brandId = productValue.brand_id;
    product.value.quantity = productValue.quantity;
    product.value.description = productValue.description;
    product.value.inStock = productValue.in_stock;
    product.value.published = productValue.published;
    product.value.price = productValue.price;

    product.value.productImages = productValue.product_images;

    // productImages.value = productValue.product_images;
};

const deleteImage = async(image, index) => {
    try {
        await router.delete(`/admin/products/image/${image.id}`, {
            onSuccess: (page) => {
                product.value.productImages.splice(index, 1);
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "success",
                    showConfirmButton: false,
                    title: page.props.flash.success,
                    timer: 3000,
                    timerProgressBar: true,
                });
            },
        });
    } catch (error) {
        console.error("Error deleting image:", error);
    }
};

const updateProduct = async () => {
    const formData = new FormData();
    formData.append("title", product.value.title);
    formData.append("category_id", product.value.categoryId);
    formData.append("brand_id", product.value.brandId);
    formData.append("quantity", product.value.quantity);
    formData.append("description", product.value.description);
    formData.append("price", product.value.price);
    formData.append("_method", "PUT");

    for (const image of productImages.value) {
        formData.append("product_images[]", image.raw);
    }

    try {
        await router.post(`products/update/${product.value.id}`, formData, {
            onSuccess: (page) => {
                isAddModalOpen.value = false;
                dialogVisible.value = false
                resetFormValues();

                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "success",
                    showConfirmButton: false,
                    title: page.props.flash.success,
                    timer: 3000,
                    timerProgressBar: true,
                });
            },
        });
    } catch (error) {
        console.error("Error uploading images:", error);
    }
};

const deleteProduct = async (product, index) => {
    Swal.fire({
        title: "Estás seguro?",
        text: "No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "Cancelar",
    }).then( async (result) => {
        if (result.isConfirmed) {
            try {
                await router.delete(`products/destroy/${product.id}`, {
                    onSuccess: (page) => {
                        // this.deleteImage(product, index);
                        // products.value.splice(index, 1);
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "success",
                            showConfirmButton: false,
                            title: page.props.flash.success,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    },
                });
            } catch (error) {
                console.error("Error deleting product:", error);
            }
        }
    })

};

// necesito que el searchQuery se mantenga en la url
const searchQuery = ref(usePage().props.query?.search || "");

const handleSearch = (value) => {
    searchQuery.value = value;
    router.get(route("admin.products.index"), { search: searchQuery.value }, { preserveState: true });
};

const publishItProduct = async (product) => {
    const formData = new FormData();
    formData.append("_method", "PUT");
    try {
        await router.put(`products/publishit/${product.id}`, formData, {
            onSuccess: (page) => {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "success",
                    showConfirmButton: false,
                    title: page.props.flash.success,
                    timer: 3000,
                    timerProgressBar: true,
                });
            },
        });
    } catch (error) {
        console.error("Error publishing product:", error);
    }
};

const selectedCategory = ref(usePage().props.query?.category || "");  // Almacena la categoría seleccionada

const handleCategoryFilter = (categoryId) => {
    selectedCategory.value = categoryId; // Actualiza la categoría seleccionada
    router.get(route("admin.products.index"), { category: selectedCategory.value, search: searchQuery.value }, { preserveState: true });
};


</script>

<template>
    <section class="bg-gray-50 p-3 sm:p-5">


        <el-dialog
            v-model="dialogVisible"
            :title="editMode ? 'Editar Producto' : 'Agregar Producto'"
            width="50%"
            align-center
        >
            <form class="px-5 mx-auto" @submit.prevent="editMode ? updateProduct() :  addProdcut()">
                <div class="relative z-0 w-full mb-5 group">
                    <input v-model="product.title" type="text" name="floating_title" id="floating_title" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required maxlength="100" />

                    <label for="floating_title" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Titulo</label>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <input v-model="product.price" type="number"
                            step="0.01" min="0" max="9999999"
                            name="floating_price" id="floating_price" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="floating_price" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Precio</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input v-model="product.quantity" type="number" name="floating_quantity" id="floating_quantity" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="floating_quantity" class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Cantidad</label>
                    </div>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <textarea v-model="product.description" name="floating_description" id="floating_description" rows="4" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600" placeholder=" " ></textarea>

                    <label for="floating_description" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Descripcion</label>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <label for="floating_brand" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Maarcas</label>

                    <select v-model="product.brandId" name="floating_brand" id="floating_brand"  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                            {{ brand.name }}
                        </option>
                    </select>
                </div>

                <div class="relative z-0 w-full mb-5 group">
                    <label for="floating_category" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Categorias</label>

                    <select v-model="product.categoryId" name="floating_category" id="floating_category"  class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                    </select>
                </div>

                <div class="grid md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <el-upload
                            v-model:file-list="productImages"
                            list-type="picture-card"
                            multiple
                            :auto-upload="false"
                            :on-preview="handlePictureCardPreview"
                            :on-remove="handleRemove"
                            :on-change="handleFileChange"
                        >
                            <el-icon><Plus /></el-icon>
                        </el-upload>

                        <el-dialog v-model="dialogImageVisible">
                            <img w-full :src="dialogImageUrl" alt="Preview Image" />
                        </el-dialog>
                    </div>
                </div>

                <div class="flex flex-nowrap mb-5 text-center aling-center">
                    <div v-for="(image, index) in product.productImages" :key="image.id" class="relative mx-2">
                        <img class="w-32 h-32 rounded" :src="`/storage/${image.image}`" alt="">
                        <span
                            class="text-red-500 rounded-full px-1 text-sm font-bold absolute top-1 left-1 transform -translate-x-1/2 -translate-y-1/2 cursor-pointer"
                            @click="deleteImage(image, index)"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="size-5 transition delay-150 duration-300 hover:-translate-y-1 hover:scale-110 hover:text-red-700"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </span>
                    </div>
                </div>

                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Guardar</button>
            </form>
        </el-dialog>

        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
                        <ProductSearch v-model="searchQuery" @search="handleSearch" />
                    </div>
                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0"
                    >
                        <button
                            @click="openAddModal"
                            type="button"
                            class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2"
                        >
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Agregar Producto
                        </button>
                        <div class="flex items-center space-x-3 w-full md:w-auto">
                            <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown"
                                class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                    class="h-4 w-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                        clip-rule="evenodd" />
                                </svg>
                                Filtrar
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                            <div id="filterDropdown"
                                class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                                <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                    Elija la categoria
                                </h6>
                                <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
                                    <li class="flex items-center" v-for="category in categories" :key="category.id">
                                        <input
                                            type="radio"
                                            :id="'category-' + category.id"
                                            :value="category.id"
                                            v-model="selectedCategory"
                                            @change="handleCategoryFilter(category.id)"
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                        />
                                        <label :for="'category-' + category.id" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ category.name }}
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <ProductTable
                        :products="products.data"
                        @edit-product="openEditModal"
                        @delete-product="deleteProduct"
                        @publishit-product="publishItProduct"
                    />
                </div>

                <Pagination :pagination="products" />
            </div>
        </div>
    </section>
</template>
