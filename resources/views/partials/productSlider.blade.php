<!-- productos relacionados -->

<section>
    <div class="title__general fadeInUp wow animated">
        <p><strong>Productos </strong>relacionados</p>
    </div>

    <div class="container">
        <div class="main-slider__content">
            
            @foreach(App\Product::with('category')->inRandomOrder()->where('amount', '>', 0)->take(20)->get() as $product)
                <a href="{{ url('/product/'.$product->slug) }}">
                    <div class="main-slider__item">
                        <div class="content-slider">
                            @if($product->is_external == false)
                                <img src="{{ asset('/images/products/'.$product->picture) }}" alt="" style="width: 100%">
                            @else
                                <img src="{{ $product->picture }}" alt="" style="width: 100%">
                            @endif
                        </div>
                        <div class="main-slider__text">
                            <span>{{ $product->name }}</span>
                            @if($product->category)
                                <p class="title">{{ $product->category->name }}</p>
                            @endif
                            @if($product->external_price > 0)
                                <span class="price">$ {{ number_format(intval($product->external_price * App\DolarPrice::first()->price), 0, ",", ".") }}</span>
                            @else
                            <span class="price">$ {{ number_format($product->price, 0, ",", ".") }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>