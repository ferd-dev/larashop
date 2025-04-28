<template>
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-4 py-3">#</th>
                <th scope="col" class="px-4 py-3">Nombre del Producto</th>
                <th scope="col" class="px-4 py-3">Categoria</th>
                <th scope="col" class="px-4 py-3">Marca</th>
                <th scope="col" class="px-4 py-3">Cantidad</th>
                <th scope="col" class="px-4 py-3">Precio</th>
                <th scope="col" class="px-4 py-3">Stock</th>
                <th scope="col" class="px-4 py-3">Publicado</th>
                <th scope="col" class="px-4 py-3">
                    <span class="">Acciones</span>
                </th>
            </tr>
        </thead>
        <tbody>
            <ProductTableRow
                v-for="product in products"
                :key="product.id"
                :product="product"
                :index="products.indexOf(product) + 1"
                @edit="emitEdit"
                @delete="emitDelete"
                @publishit="emitPublishIt"
            />
        </tbody>
    </table>
</template>

<script setup>
import ProductTableRow from './ProductTableRow.vue';

defineProps({
    products: Array
});

const emit = defineEmits(['edit-product', 'delete-product', 'publishit-product']);

const emitEdit = (product) => {
    emit('edit-product', product);
};

const emitDelete = (product) => {
    emit('delete-product', product);
};

const emitPublishIt = (product) => {
    emit('publishit-product', product);
};
</script>
