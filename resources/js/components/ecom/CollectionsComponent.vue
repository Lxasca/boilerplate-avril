<template>
    <div v-if="collections.length">
        <div v-for="collection in collections" :key="collection.id">
            <h2>{{ collection.name }}</h2>
            <div v-for="product in collection.products" :key="product.id">
                <router-link :to="{ name: 'boutique-produit', params: { slug: product.slug } }">
                    {{ product.name }} — {{ formatPrice(product.price) }}
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { formatPrice } from '../../../src/helpers/format';
export default {
    name: 'CollectionsComponent',
    data() {
        return {
            collections: []
        }
    },
    mounted() {
        axios.get('/collections').then((response) => {
            this.collections = response.data;
        });
    },
    methods: {
        formatPrice
    }
}
</script>