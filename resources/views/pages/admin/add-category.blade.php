@extends("layouts.admin")

@section("main")
<div class="px-6">
    {{ Breadcrumbs::render('addCategory') }}
</div>
<article class="py-6 space-y-8">
    <h1 class="text-center text-4xl font-semibold">Add New Category</h1>
    <form action="/dashboard/categories/addCategory" method="post" class="space-y-8 max-w-md mx-auto">
        @csrf
        <x-shared.form.input name="category" placeholder="Category Name" />
        <x-shared.form.error name="category" />
        <x-shared.form.submit-button> Add Category </x-shared.form.submit-button>
    </form>
</article>

@endsection