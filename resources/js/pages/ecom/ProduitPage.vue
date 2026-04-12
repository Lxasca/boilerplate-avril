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
                    Ajouter au panier
                </button>
            </section>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ProduitPage',
    data() {
        return {
            product: null,
            item: null
        }
    },
    mounted() {
        const slug = this.$route.params.slug;
        this.getProduct(slug);
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
            console.log('productId : ', productId)
            axios
            .post('/cart/add', { product_id: productId})
            .then((response) => {
                console.log('item : ', response.data)
                this.item = response.data
            })
        }
    }
}
</script>