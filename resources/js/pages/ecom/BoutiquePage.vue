<template>
    <h1>Boutique</h1>

    <section>
        <div>
            <label>Prix min</label>
            <input type="number" v-model="filters.min_price">
            <label>Prix max</label>
            <input type="number" v-model="filters.max_price">
        </div>

        <div>
            <label>Tailles</label>
            <label v-for="size in ['XS','S','M','L','XL','XXL']" :key="size">
                <input type="checkbox" :value="size" v-model="filters.sizes"> {{ size }}
            </label>
        </div>

        <div>
            <label>Contenances</label>
            <label v-for="capacity in ['50ml','100ml','200ml','250ml','500ml','1L','1.5L','2L']" :key="capacity">
                <input type="checkbox" :value="capacity" v-model="filters.capacities"> {{ capacity }}
            </label>
        </div>

        <div>
            <label>Couleurs</label>
            <label v-for="color in ['Rouge','Bleu','Noir','Gris','Blanc','Vert','Jaune','Rose']" :key="color">
                <input type="checkbox" :value="color" v-model="filters.colors"> {{ color }}
            </label>
        </div>
    </section>

    <section>
        <div v-for="product in products" :key="product.id">
            <div class="card">

                <div v-if="product.collections.length">
                    <span class="badge-collection" v-for="collection in product.collections" :key="collection.id">
                        {{ collection.name }}
                    </span>
                </div>
                
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
            hasMore: true,
            filters: {
                min_price: null,
                max_price: null,
                sizes: [],
                capacities: [],
                colors: []
            }
        }
    },
    watch: {
        filters: {
            deep: true,
            handler() {
                this.applyFilters();
            }
        }
    },
    computed: {
        items() {
            return useCartStore().cart?.items
        }
    },
    mounted() {
        this.getProducts();
        window.addEventListener('scroll', this.onScroll);
    },
    beforeUnmount() {
        window.removeEventListener('scroll', this.onScroll);
    },
    methods: {
        formatPrice, formatTruncate,
        getProducts() {
            if (!this.hasMore) return;
            axios.get('/products', { 
                params: { 
                    page: this.page, 
                    'sizes[]': this.filters.sizes,
                    'colors[]': this.filters.colors,
                    'capacities[]': this.filters.capacities,
                    min_price: this.filters.min_price,
                    max_price: this.filters.max_price,
                }
            }).then((response) => {
                this.products.push(...response.data.data);
                this.hasMore = response.data.next_page_url !== null;
                this.page++;
            });
        },
        applyFilters() {
            this.products = [];
            this.page = 1;
            this.hasMore = true;
            this.getProducts();
        },
        onScroll() {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
                this.getProducts();
            }
        }
    }
}
</script>