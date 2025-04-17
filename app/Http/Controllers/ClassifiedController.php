<?php

namespace App\Http\Controllers;

use App\Events\ClassifiedCreate;
use App\Http\Queries\ClassifiedQuery;
use App\Http\Requests\ClassifiedRequest;
use App\Http\Requests\ClassifiedUpdateRequest;
use App\Http\Resources\ClassifiedResource;
use App\Models\Classified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClassifiedController extends Controller
{
    // Вывод всех объявлений
    public function index(Request $request, ClassifiedQuery $classifiedQuery): JsonResponse
    {
        $classifieds = $classifiedQuery->sort($request);

        return response()->json(ClassifiedResource::collection($classifieds));
    }

    // Вывод объявлений пользователя
    public function userClassifieds(Request $request): JsonResponse
    {
        $classifieds = Classified::where('user_id', $request->user()->id)->get();

        return response()->json(ClassifiedResource::collection($classifieds));
    }

    // Просмотр объявления
    public function show(Classified $classified): JsonResponse
    {
        return response()->json(new ClassifiedResource($classified));
    }

    // Создание
    public function store(ClassifiedRequest $request): JsonResponse
    {
        $imagePath = $request->file('image')->store('classifieds', 'public');
        $imageFullPath = Storage::disk('public')->url($imagePath);

        $classified = Classified::create([
            'user_id' => $request->user()->id,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image_url' => $imageFullPath,
        ]);

        ClassifiedCreate::dispatch($classified);

        return response()->json(new ClassifiedResource($classified), 201);
    }

    // Редактирование
    public function update(ClassifiedUpdateRequest $request, Classified $classified): JsonResponse
    {
        if ($request->user()->id !== $classified->user_id) {
            return response()->json([], 403);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('classifieds', 'public');
            $imageFullPath = Storage::disk('public')->url($imagePath);

            $localPath = Str::after($classified->image_url, '/storage/');
            Storage::disk('public')->delete($localPath);
        }

        $classified->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image_url' => $imageFullPath ?? $classified->image_url,
        ]);

        return response()->json(new ClassifiedResource($classified));
    }

    // Удаление
    public function destroy(Request $request, Classified $classified): JsonResponse
    {
        if ($request->user()->id !== $classified->user_id) {
            return response()->json([], 403);
        }

        $classified->delete();

        return response()->json(null, 204);
    }
}
