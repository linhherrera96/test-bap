<?php

namespace App\Http\Controllers\Api;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JobController extends BaseController
{
    protected $job;
    public function __construct(
        Job $job
    ) {
        $this->job = $job;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function filterGetJobRules()
    {
        return [
            'id' => 'nullable|integer',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'status_complete' => 'nullable|string',
            'due_date' => 'nullable|string'
        ];
    }

    /**
     *     @OA\Post(
     *     path="/api/jobs/list",
     *     summary="get all jobs",
     *      @OA\Parameter(
     *         description="page number need to input info",
     *         in="query",
     *         name="page",
     *         example="1",
     *         @OA\Schema(
     *         type="integer"
     *        )
     *      ),
     *      @OA\RequestBody(
     *        @OA\JsonContent(
     *             type="object",
     *               @OA\Property(
     *               property="id",
     *               example="",
     *               type="string",
     *              ),
     *               @OA\Property(
     *               property="title",
     *               example="",
     *               type="string",
     *              ),
     *              @OA\Property(
     *              property="description",
     *              example="",
     *              type="string",
     *              ),
     *              @OA\Property(
     *              property="status_complete",
     *              example="",
     *              type="string",
     *              ),
     *              @OA\Property(
     *              property="due_date",
     *              example="",
     *              type="string",
     *              ),
     *              @OA\Property(
     *              property="per_page",
     *              example="10",
     *              type="integer",
     *              ),
     *         )
     *     ),
     *     @OA\Response(
     *        response="200",
     *        description="Successful",
     *     ),
     *     @OA\Response(
     *        response="400",
     *        description="Bad Request",
     *     ),
     *     @OA\Response(
     *        response="401",
     *        description="許可がありません。",
     *     ),
     *    @OA\Response(
     *        response="500",
     *        description="Internal Server Error",
     *     ),
     * )
     *
     */
    public function getListJobs(Request $request)
    {
        try {
            $credentials = $request->all();
            $validator = Validator::make($credentials, $this->filterGetJobRules());
            $errors = $validator->errors();
            if ($errors->first()) return $this->sendError($errors->first());
            $results = $this->job->getAllJobs($request->per_page, $request);
            return $this->sendSuccessResponse($results);
        } catch (Exception $e) {
            $this->log("getListJobs", null, ["request" => $request->all()], $e->getMessage());
            return $this->sendError(__('app.system_error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function rules()
    {
        return [
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'status_complete' => 'nullable|string',
            'due_date' => 'nullable|string'
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *     @OA\Post(
     *     path="/api/job/edit/{id}",
     *     summary="Edit job",
     *     tags={"Job"},
     *      security={ {"bearer": {}} },
     *      @OA\Parameter(
     *         description="ID of job need to input info",
     *         in="path",
     *         name="id",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *         type="integer"
     *        )
     *      ),
     *      @OA\RequestBody(
     *        @OA\JsonContent(
     *             type="object",
    *                          @OA\Property(
    *                             property="title",
    *                             example="",
    *                             type="string",
    *                         ),
    *                          @OA\Property(
    *                             property="description",
    *                             example="",
    *                             type="string",
    *                         ),
    *                          @OA\Property(
    *                             property="status_complete",
    *                             example="",
    *                             type="string",
    *                         ),
    *                         @OA\Property(
    *                             property="due_date",
    *                             example="",
    *                             type="string",
    *                         )
     *         )
     *     ),
     *     @OA\Response(
     *        response="200",
     *        description="Successful",
     *     ),
     *     @OA\Response(
     *        response="400",
     *        description="Bad Request",
     *     ),
     *     @OA\Response(
     *        response="401",
     *        description="許可がありません。",
     *     ),
     *    @OA\Response(
     *        response="500",
     *        description="Internal Server Error",
     *     ),
     * )
     *
     */
    public function update(Request $request, $id)
    {
        try {
            $rules = $this->rules();
            $validator = Validator::make(array_filter($request->all()), $rules);
            $errors = $validator->errors();
            if ($errors->first()) {
                return $this->sendError($errors->first());
            }
  
            DB::beginTransaction();

            // check job exist
            $job = $this->job->findByJobId($id);
            if (!$job) {
                return $this->sendError(__('app.not_exist', ['attribute' => __('app.job')]));
            }
            $job['title'] = isset($request->title) ? $request->title : $job['title'];
            $job['description'] = isset($request->description) ? $request->description : $job['description'];
            $job['status_complete'] = isset($request->status_complete) ? $request->status_complete : $job['status_complete'];
            $job['due_date'] = isset($request->due_date) ? $request->due_date : $job['due_date'];

            //update job
            $this->job->updateJob($id, $job->toArray());

            DB::commit();
            return $this->sendSuccess(__('app.update'));
        } catch (Exception $e) {
            error_log($e);
            DB::rollBack();
            $this->log("updateJob", null, ["job_id" => $id], $e->getMessage());
            return $this->sendError(__('app.system_error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *     @OA\Put(
     *     path="/api/job/create",
     *     summary="Create job",
     *     tags={"Job"},
     *      security={ {"bearer": {}} },
     *      @OA\RequestBody(
     *        @OA\JsonContent(
     *             type="object",
    *                          @OA\Property(
    *                             property="title",
    *                             example="",
    *                             type="string",
    *                         ),
    *                          @OA\Property(
    *                             property="description",
    *                             example="",
    *                             type="string",
    *                         ),
    *                          @OA\Property(
    *                             property="status_complete",
    *                             example="",
    *                             type="string",
    *                         ),
    *                         @OA\Property(
    *                             property="due_date",
    *                             example="",
    *                             type="string",
    *                         )
     *         )
     *     ),
     *     @OA\Response(
     *        response="200",
     *        description="Successful",
     *     ),
     *     @OA\Response(
     *        response="400",
     *        description="Bad Request",
     *     ),
     *     @OA\Response(
     *        response="401",
     *        description="許可がありません。",
     *     ),
     *    @OA\Response(
     *        response="500",
     *        description="Internal Server Error",
     *     ),
     * )
     *
     */
    public function create(Request $request)
    {
        try {
            $rules = $this->rules();
            $validator = Validator::make(array_filter($request->all()), $rules);
            $errors = $validator->errors();
            if ($errors->first()) {
                return $this->sendError($errors->first());
            }
  
            DB::beginTransaction();

            $job = new Job();
            $job['title'] = $request->title;
            $job['description'] = $request->description;
            $job['status_complete'] = $request->status_complete;
            $job['due_date'] = $request->due_date;

            //create job
            $job->save();

            DB::commit();
            return $this->sendSuccess(__('app.create'));
        } catch (Exception $e) {
            error_log($e);
            DB::rollBack();
            $this->log("createJob", null, ["job_id" => $id], $e->getMessage());
            return $this->sendError(__('app.system_error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *     @OA\Get(
     *     path="/api/job/edit/{id}",
     *     summary="Edit job",
     *     tags={"Job"},
     *      security={ {"bearer": {}} },
     *      @OA\Parameter(
     *         description="ID of job need to input info",
     *         in="path",
     *         name="id",
     *         required=true,
     *         example="1",
     *         @OA\Schema(
     *         type="integer"
     *        )
     *      ),
     *     @OA\Response(
     *        response="200",
     *        description="Successful",
     *     ),
     *     @OA\Response(
     *        response="400",
     *        description="Bad Request",
     *     ),
     *     @OA\Response(
     *        response="401",
     *        description="許可がありません。",
     *     ),
     *    @OA\Response(
     *        response="500",
     *        description="Internal Server Error",
     *     ),
     * )
     *
     */
    public function delete($id)
    {
        try {
            DB::beginTransaction();

            // check job exist
            $job = $this->job->findByJobId($id);
            if (!$job) {
                return $this->sendError(__('app.not_exist', ['attribute' => __('app.job')]));
            }
            //update job
            $this->job->deleteJobById($id);

            DB::commit();
            return $this->sendSuccess(__('app.delete'));
        } catch (Exception $e) {
            error_log($e);
            DB::rollBack();
            $this->log("updateJob", null, ["job_id" => $id], $e->getMessage());
            return $this->sendError(__('app.system_error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
