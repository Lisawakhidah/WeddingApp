<a href="{{ route('product', ['product' => $product->id]) }}" class="product_card">
    <div>
        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ ucfirst($product->title) }}">
    </div>
    <h5 style="font-family: 'Roboto'">{{ ucfirst($product->title) }}</h5>
    <p>{{ "Rp.".number_format($product->price) }}</p>
</a>