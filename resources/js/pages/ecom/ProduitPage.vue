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
                {{ formatPrice(selectedVariant?.price || product.price) }}
            </p>
            

            <!-- sections des variantes -->
            <section>
                <div v-if="product.product_variants.length > 0">
                    <div v-for="variant in product.product_variants" :key="variant.id">
                        <button 
                            v-for="attr in ['color', 'size', 'capacity'].filter(a => variant[a])" 
                            :key="attr"
                            @click="selectAttr(attr, variant[attr])"
                            :class="{ active: selectedColor === variant[attr] || selectedSize === variant[attr] || selectedCapacity === variant[attr] }"
                        >
                            {{ variant[attr] }}
                        </button>
                    </div>
                </div>
            </section>

            <p v-if="product.stock < 10">
                Seulement {{ product.stock }} produits en stock
            </p>

            <br>
            <section>
                    <button @click="add(product.id)">
                        <span v-if="itemIsInCart">+</span>
                        <span v-else>Ajouter</span>
                    </button>

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
            product: null,
            selectedVariant: null,
            selectedColor: null,
            selectedSize: null,
            selectedCapacity: null
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
        },
        selectedVariant() {
            return this.product?.product_variants.find(v => 
                v.color === this.selectedColor &&
                v.size === this.selectedSize &&
                v.capacity === this.selectedCapacity
            ) || null;
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
        },
        selectVariant(variantId) {
            this.selectedVariant = this.product.product_variants.find(v => v.id === variantId);
        },
        selectAttr(type, value) {
            if (this['selected' + type.charAt(0).toUpperCase() + type.slice(1)] === value) {
                this['selected' + type.charAt(0).toUpperCase() + type.slice(1)] = null;
            } else {
                this['selected' + type.charAt(0).toUpperCase() + type.slice(1)] = value;
            }
        }
    }
}
</script>

<style scoped>
.active {
    border: 2px solid black;
    font-weight: bold;
}
</style>