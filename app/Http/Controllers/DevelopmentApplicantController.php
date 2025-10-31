<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\DevelopmentApplicantResource;
use App\Http\Requests\DevelopmentApplicantStoreRequest;
use App\Http\Requests\DevelopmentApplicantUpdateRequest;
use App\Interface\DevelopmentApplicantRepositoryInterface;

class DevelopmentApplicantController extends Controller
{
    private DevelopmentApplicantRepositoryInterface $developmentApplicantRepository;

    public function __construct(DevelopmentApplicantRepositoryInterface $developmentApplicantRepository)
    {
        $this->developmentApplicantRepository = $developmentApplicantRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $developmentApplicants = $this->developmentApplicantRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data Development Applicant Berhasil Diambil', DevelopmentApplicantResource::collection($developmentApplicants), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search' => 'nullable|string',
            'row_per_page' => 'required|integer',
        ]);

        try {
            $developmentApplicants = $this->developmentApplicantRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page'],
            );

            return ResponseHelper::jsonResponse(true, 'Data Event berhasil Diambil', PaginateResource::make($developmentApplicants, DevelopmentApplicantResource::class), 20 );
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DevelopmentApplicantStoreRequest $request)
    {
        $request = $request->validated();

        try {
            $developmentApplicant = $this->developmentApplicantRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Development Applicant Berhasil Dibuat', new DevelopmentApplicantResource($developmentApplicant), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $developmentApplicant = $this->developmentApplicantRepository->getById($id);

            if (!$developmentApplicant) {
                return ResponseHelper::jsonResponse(false, 'Development Applicant Tidak Ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data Development Applicant Berhasil Diambil', new DevelopmentApplicantResource($developmentApplicant), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DevelopmentApplicantUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $developmentApplicant = $this->developmentApplicantRepository->getById($id);

            if (!$developmentApplicant) {
                return ResponseHelper::jsonResponse(false, 'Development Applicant Tidak Ditemukan', null, 404);
            }

            $developmentApplicant = $this->developmentApplicantRepository->update($id, $data);

            return ResponseHelper::jsonResponse(true, 'Development Applicant Berhasil Diupdate', new DevelopmentApplicantResource($developmentApplicant), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $developmentApplicant = $this->developmentApplicantRepository->getById($id);

            if (!$developmentApplicant) {
                return ResponseHelper::jsonResponse(false, 'Development Applicant Tidak Ditemukan', null, 404);
            }

            $this->developmentApplicantRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Development Applicant Berhasil Dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
