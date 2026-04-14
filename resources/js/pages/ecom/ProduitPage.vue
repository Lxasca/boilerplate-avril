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
                    <div v-if="availableSizes.length">
                        <button v-for="size in availableSizes" :key="size"
                            @click="selectAttr('size', size)"
                            :class="{ active: selectedSize === size }"
                            :disabled="!isAttrAvailable('size', size)"
                            >
                                {{ size }}
                        </button>
                    </div>

                    <div v-if="availableCapacities.length">
                        <button v-for="capacity in availableCapacities" :key="capacity"
                            @click="selectAttr('capacity', capacity)"
                            :class="{ active: selectedCapacity === capacity }"
                            :disabled="!isAttrAvailable('capacity', capacity)"
                            >
                                {{ capacity }}
                        </button>
                    </div>

                    <div v-if="availableColors.length && (selectedSize || selectedCapacity)">
                        <button v-for="color in availableColors" :key="color"
                            @click="selectAttr('color', color)"
                            :class="{ active: selectedColor === color }"
                            :disabled="!isAttrAvailable('color', color)"
                            >
                                {{ color }}
                        </button>
                    </div>
                </div>
            </section>

            <p v-if="product.stock < 10">
                Seulement {{ product.stock }}
                <span v-if="product.stock == 1">produit</span>
                <span v-else>produits</span>
                en stock
            </p>

            <br>
            <section>
                <button
                @click="add(selectedVariant ? selectedVariant.id : product.id, selectedVariant ? true : false)"
                :disabled="!canAddToCart">
                    <span>Ajouter</span>
                </button>
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
        availableColors() {
            let variants = this.product.product_variants;
            
            if (this.selectedSize ) {
                variants = variants.filter(v => v.size === this.selectedSize);
            }

            if (this.selectedCapacity) {
                variants = variants.filter(v => v.capacity === this.selectedCapacity);
            }

            return [...new Set(variants.filter(v => v.color).map(v => v.color))];
        },
        availableSizes() {
            if (this.selectedCapacity) return [];

            return [...new Set(this.product.product_variants.filter(v => v.size).map(v => v.size))]
        },
        availableCapacities() {
            if (this.selectedSize) return [];

            return [...new Set(this.product.product_variants.filter(v => v.capacity).map(v => v.capacity))]
        },
        selectedVariant() {
            return this.product?.product_variants.find(v => 
                (this.selectedColor ? v.color === this.selectedColor : !v.color || true) &&
                (this.selectedSize ? v.size === this.selectedSize : !v.size || true) &&
                (this.selectedCapacity ? v.capacity === this.selectedCapacity : !v.capacity || true)
            ) || null;
        },
        canAddToCart() {
            if (!this.product.product_variants.length) return true;
            
            const hasColors = this.availableColors.length > 0;
            const hasSizes = this.availableSizes.length > 0;
            const hasCapacities = this.availableCapacities.length > 0;
            return (!hasColors || this.selectedColor) &&
                (!hasSizes || this.selectedSize) &&
                (!hasCapacities || this.selectedCapacity);
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
        add(productId, isVariant) {
            const cartStore = useCartStore();
            cartStore.add(productId, isVariant);
        },
        selectAttr(type, value) {
            if (this['selected' + type.charAt(0).toUpperCase() + type.slice(1)] === value) {
                this['selected' + type.charAt(0).toUpperCase() + type.slice(1)] = null;
            } else {
                this['selected' + type.charAt(0).toUpperCase() + type.slice(1)] = value;
            }
        },
        isAttrAvailable(type, value) {
            return this.product.product_variants.some(v => {
                if (v[type] !== value || v.stock === 0) return false;
                if (type !== 'color' && this.selectedColor) return v.color === this.selectedColor;
                if (type !== 'size' && this.selectedSize) return v.size === this.selectedSize;
                if (type !== 'capacity' && this.selectedCapacity) return v.capacity === this.selectedCapacity;
                return true;
            });
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