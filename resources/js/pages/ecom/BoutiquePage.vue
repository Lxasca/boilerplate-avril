<template>
    <h1>Boutique</h1>

    <section>
        <div v-for="product in products" :key="product.id">
            <div class="card">
                <h5>
                    {{ product.name }}
                </h5>

                <p>
                    {{ formatTruncate(product.description) }}
                </p>

                <p>
                    {{ formatPrice(product.price) }}
                </p>

                <p v-if="product.stock < 10">
                    Seulement {{ product.stock }} produits en stock
                </p>

                <section>
                    <router-link :to="{ name: 'boutique-produit', params: { slug: product.slug } }">
                        Voir plus
                    </router-link>
                </section>
            </div>
        </div>
    </section>
</template>

<script>
import axios from 'axios';
import { useCartStore } from '../../../src/stores/cartStore';
import { formatPrice, formatTruncate } from '../../../src/helpers/format';

export default {
    name: 'BoutiquePage',
    data() {
        return {
            products: [],
            page: 1,
            hasMore: true
        }
    },
    mounted() {
        this.getProducts();
        window.addEventListener('scroll', this.onScroll);
    },
    beforeUnmount() {
        window.removeEventListener('scroll', this.onScroll);
    },
    computed: {
        items() {
            return useCartStore().cart?.items
        }
    },
    methods: {
        formatPrice, formatTruncate,
        getProducts() {
            if (!this.hasMore) return;
            axios.get('/products', { params: { page: this.page } }).then((response) => {
                this.products.push(...response.data.data);
                this.hasMore = response.data.next_page_url !== null;
                this.page++;
            });
        },
        onScroll() {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
                this.getProducts();
            }
        }
    }
}
</script>