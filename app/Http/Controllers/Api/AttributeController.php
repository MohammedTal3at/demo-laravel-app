<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attribute\CreateAttributeRequest;
use App\Http\Requests\Attribute\UpdateAttributeRequest;
use App\Models\Attribute;
use App\Services\AttributeService;
use Illuminate\Http\JsonResponse;

class AttributeController extends Controller
{
    private AttributeService $attributeService;

    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }

    public function index(): JsonResponse
    {
        $attributes = $this->attributeService->getAllAttributes();
        return response()->json(['data' => $attributes]);
    }

    public function store(CreateAttributeRequest $request): JsonResponse
    {
        $attribute = $this->attributeService->create($request->toDTO());
        return response()->json(['data' => $attribute], 201);
    }

    public function show(Attribute $attribute): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $attribute
        ]);
    }

    public function update(UpdateAttributeRequest $request, Attribute $attribute): JsonResponse
    {
        $attribute = $this->attributeService->update($attribute, $request->toDTO());
        return response()->json(['data' => $attribute]);
    }

    public function destroy(Attribute $attribute): JsonResponse
    {
        $this->attributeService->delete($attribute);
        return response()->json(null, 204);
    }
}
