<template>
    <h1>Boutique</h1>

    <section>
        <div v-for="product in products" :key="product.id">
            {{ product.name }}
        </div>
    </section>
</template>

<script>
import axios from 'axios';

export default {
    name: 'BoutiquePage',
    data() {
        return {
            products: []
        }
    },
    mounted() {
        this.getProducts();
    },
    methods: {
        getProducts() {
            axios
            .get('/products')
            .then((response) => {
                this.products = response.data;
            })
            .catch((error) => {
                console.log('erreur ', error)
            })
        }
    }
}
</script>