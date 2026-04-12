<template>
    <div  v-if="item">
        {{ item }}
    </div>

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
                {{ product.price }}€
            </p>

            <p v-if="product.stock < 10">
                Seulement {{ product.stock }} produits en stock
            </p>

            <section>
                <button @click="add(product.id)">
                    +
                </button>
                <button @click="decrement(product.id)">
                    -
                </button>
            </section>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { useCartStore } from '../../../src/stores/cartStore';

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
        item() {
            return useCartStore().item
        }
    },
    methods: {
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