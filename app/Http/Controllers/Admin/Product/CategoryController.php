<?php

namespace App\Http\Controllers\Admin\Product;

use App\Contracts\Repositories\CategoryRepositoryInterface;
use App\Contracts\Repositories\TranslationRepositoryInterface;
use App\Enums\ViewPaths\Admin\Category;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\CategoryAddRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Services\CategoryService;
use App\Traits\PaginatorTrait;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    use PaginatorTrait;

    public function __construct(
        private readonly CategoryRepositoryInterface        $categoryRepo,
        private readonly TranslationRepositoryInterface     $translationRepo,
    )
    {
    }

    /**
     * @param Request|null $request
     * @param string|null $type
     * @return View
     * Index function is the starting point of a controller
     */
    public function index(Request|null $request, string $type = null): View
    {
        return $this->getAddView($request);
    }

    public function getAddView(Request $request): View
    {
        $categories = $this->categoryRepo->getListWhere(orderBy: ['id'=>'desc'], searchValue: $request->get('searchValue'), filters: ['position' => 0], dataLimit: getWebConfig(name: 'pagination_limit'));
        $languages = getWebConfig(name: 'pnc_language') ?? null;
        $defaultLanguage = $languages[0];
        return view(Category::LIST[VIEW], [
            'categories' => $categories,
            'languages' => $languages,
            'defaultLanguage' => $defaultLanguage,
        ]);
    }

    public function getUpdateView(string|int $id): View
    {
        $category = $this->categoryRepo->getFirstWhere(params:['id'=>$id], relations: ['translations']);
        $languages = getWebConfig(name: 'pnc_language') ?? null;
        $defaultLanguage = $languages[0];
        return view(Category::UPDATE[VIEW], [
            'category' => $category,
            'languages' => $languages,
            'defaultLanguage' => $defaultLanguage,
        ]);
    }

    public function add(CategoryAddRequest $request, CategoryService $categoryService): RedirectResponse
    {
        $dataArray = $categoryService->getAddData(request:$request);
        $savedCategory = $this->categoryRepo->add(data:$dataArray);
        $this->translationRepo->add(request:$request, model:'App\Models\Category', id:$savedCategory->id);
        Toastr::success(translate('category_added_successfully'));
        return back();
    }

    public function update(CategoryUpdateRequest $request, CategoryService $categoryService): RedirectResponse
    {
        $category = $this->categoryRepo->getFirstWhere(params:['id'=>$request['id']]);
        $dataArray = $categoryService->getUpdateData(request:$request, data: $category);
        $this->categoryRepo->update(id:$request['id'], data:$dataArray);
        $this->translationRepo->update(request:$request, model:'App\Models\Category', id:$request['id']);

        Toastr::success(translate('category_updated_successfully'));
        return back();
    }

    public function updateStatus(Request $request): JsonResponse
    {
        $data = [
            'home_status' => $request->get('home_status', 0),
        ];
        $this->categoryRepo->update(id: $request['id'], data:$data);
        return response()->json(['success' => 1,], 200);
    }

    public function delete(Request $request, CategoryService $categoryService): JsonResponse
    {
        $category = $this->categoryRepo->getFirstWhere(params: ['id'=>$request['id']], relations: ['childes.childes']);
        $categoryService->deleteImages(data:$category);
        $this->categoryRepo->delete(params: ['id'=>$request['id']]);
        return response()->json(['message'=> translate('deleted_successfully')]);
    }
}
