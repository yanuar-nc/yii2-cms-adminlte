<!-- /.error-content -->
<h2 class="headline text-yellow"> <?= $exception->statusCode ?></h2>

<div class="error-content">
    <h3><i class="fa fa-warning text-yellow"></i> Oops! Warning.</h3>

    <p> <?= $exception->getMessage() ?> </p>

    <form class="search-form">
        <div class="input-group">
            <input name="search" class="form-control" placeholder="Search" type="text">

            <div class="input-group-btn">
                <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    <!-- /.input-group -->
    </form>
</div>
<!-- /.error-content -->
