<div class="container">

    <div class="row">

        <div class="col-md-3">
            <p class="lead">Filtrs</p>
            <div class="form-group">
                <input type="text" class="form-control" wire:model="search"  placeholder="Search...">
            </div>
            <h5>Price</h5>
            <div class="row">
                <div class="col-xs-4">
                    <input class="form-control" type="number" min="0" style="width: 100%" wire:model="price_min" placeholder="Min...">
                </div>
                <div class="col-xs-1">
                    -
                </div>
                <div class="col-xs-4">
                    <input class="form-control" type="number" min="0" style="width: 100%" wire:model="price_max" placeholder="Max...">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control" id="category" wire:model="category">
                    <option value="0">All Category</option>
                    <option value="1">Phones</option>
                    <option value="2">Tablets</option>
                    <option value="3">Computers</option>
                </select>
            </div>
            <div class="form-group">
                <label for="first_owner"> First owner</label> <input id="first_owner" class="checkbox" type="checkbox" wire:model="first_owner">
            </div>
            <div class="form-group">
                <label for="has_photo"> Only with photos</label> <input id="has_photo" class="checkbox" type="checkbox" wire:model="has_photo">
            </div>

            <div class="form-group">
                <label for="sort">Order by</label>
                <select class="form-control" wire:model="sort" id="sort">
                    <option value="0">Don't sort</option>
                    <option value="1">Price Asc</option>
                    <option value="2">Price Dsc</option>
                    <option value="3">Oldest</option>
                    <option value="4">Newest</option>
                </select>
            </div>
        </div>

        <div class="col-md-9">

            {{-- <div class="row carousel-holder">

                <div class="col-md-12">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="item active">
                                <img class="slide-image" src="http://placehold.it/800x300" alt="">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="http://placehold.it/800x300" alt="">
                            </div>
                            <div class="item">
                                <img class="slide-image" src="http://placehold.it/800x300" alt="">
                            </div>
                        </div>
                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </div>
                </div>

            </div> --}}

            <div class="row">
                @if (count($products) > 0)
                    @foreach ($products as $product)
                        <?php 
                            $product->CheckPromoting($product->id);
                            $images = $product->outPutImages($product->id);
                            if($images != NULL) {
                                $img = $images[0];
                            } else {
                                $img = 'noImg.jpg';
                            }
                        ?>
                        <div class="col-sm-4 col-lg-4 col-md-4">
                            <div class="thumbnail" style="height: 100%;">
                                <img src="{{ asset("storage/images/".$img) }}" style="width: 100%; max-width:300px; height: 100%; max-height: 150px;" alt="{{ $img }}">
                                <div class="caption">
                                    <h4 class="pull-right">${{ $product->price }}</h4>
                                    <h4><a href="{{ route('product_page', $product->id) }}">{{ $product->name }}</a>
                                    </h4>
                                    <p>Description</p>
                                </div>
                                <div>
                                    <p class="pull-right">
                                        {{ $product->created_at->diffForHumans() }}</p>
                                    <p>
                                        <a href="{{ route('profile', $product->user_id) }}">{{ $product->Owner }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                    <h1>No output</h1>
                @endif
            </div>
            <div class="container d-flex align-items-center justify-content-center">
                {{ $products->links() }}
            </div>

        </div>

    </div>

</div>
<!-- /.container -->
