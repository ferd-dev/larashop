<script setup>
import { EditPen, Delete } from '@element-plus/icons-vue'

defineProps({
    product: Object,
    index: Number
});
</script>

<template>
    <tr class="border-b hover:bg-gray-50">
        <th scope="row" class="px-4 py-3 font-medium">
            {{ index }}
        </th>
        <th class="px-4 py-3 font-medium text-gray-900 ">
            {{ product.title }}
        </th>
        <td class="px-4 py-3 w-max">
            {{ product.category.name }}
        </td>
        <td class="px-4 py-3 w-max">
            {{ product.brand.name }}
        </td>
        <td class="px-4 py-3">
            {{ product.quantity }}
        </td>
        <td class="px-4 py-3 ">
            <div class="w-max">
                $ {{ product.price }}
            </div>
        </td>
        <td class="px-4 py-3">
            <div class="w-max">
                <span v-if="!product.in_stock" class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm">
                    En Stock
                </span>
                <span v-else class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm">
                    Sin Stock
                </span>
            </div>
        </td>
        <td class="px-4 py-3">
            <button v-if="!product.published" type="button" class="w-max px-3 py-2 text-xs font-medium text-center text-white rounded-lg  bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300"
            @click="$emit('publishit', product)">
                Publicado
            </button>
            <button v-else type="button" class="w-max px-3 py-2 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300"
                @click="$emit('publishit', product)"
            >
                No Publicado
            </button>
        </td>

        <td class="px-4 py-3 flex items-center justify-end">
            <button
                type="button"
                class="text-black bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2"
                @click="$emit('edit', product)"
            >
                <el-icon>
                    <EditPen />
                </el-icon>
            </button>

            <button
                type="button"
                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2"
                @click="$emit('delete', product)"
            >
                <el-icon>
                    <Delete />
                </el-icon>
            </button>
        </td>
    </tr>
</template>
