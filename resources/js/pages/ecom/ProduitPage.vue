<template>
    <div v-if="product">
        <h1>Produit page détails</h1>

        <div class="card">
            <h5>
                {{ product.name }}
            </h5>

            <p>
                {{ product.description }}
            </p>

            <p>
                {{ formatPrice(product.price) }}
            </p>

            <!-- sections des variantes -->
            <section>
                <div v-if="product.product_variants.length > 0">
                    <div v-for="variant in product.product_variants" :key="variant.id">
                        <span v-if="variant.color">{{ variant.color }}</span>
                        <span v-if="variant.size">{{ variant.size }}</span>
                        <span v-if="variant.capacity">{{ variant.capacity }}</span>
                    </div>
                </div>
            </section>

            <p v-if="product.stock < 10">
                Seulement {{ product.stock }} produits en stock
            </p>

            <section>
                <button @click="add(product.id)">+</button>
                    <span v-if="itemIsInCart">{{ items.find(i => i.product_id === product.id)?.quantity }}</span>
                    <button v-if="itemIsInCart" @click="decrement(product.id)">-</button>
            </section>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { useCartStore } from '../../../src/stores/cartStore';
import { formatPrice } from '../../../src/helpers/format';

export default {
    name: 'ProduitPage',
    data() {
        return {
            product: null
        }
    },
    mounted() {
        const slug = this.$route.params.slug;
        this.getProduct(slug);
    },
    computed: {
        items() {
            return useCartStore().cart?.items
        },
        itemIsInCart() {
            return this.items && this.items.some(i => i.product_id === this.product.id)
        }
    },
    methods: {
        formatPrice,
        getProduct(slug) {
            axios
            .get(`/product/${slug}`)
            .then((response) => {
                this.product = response.data;
            })

        },
        add(productId) {
            const cartStore = useCartStore();
            cartStore.add(productId);
        },
        decrement(productId) {
            const cartStore = useCartStore();
            cartStore.decrement(productId);
        }
    }
}
</script>