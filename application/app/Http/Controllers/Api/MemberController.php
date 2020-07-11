<?php

namespace App\Http\Controllers\Api;

use App\Events\AfterCreateMember;
use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Member;
use App\Http\Requests\MembersRequest;
use App\Http\Requests\CreateMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Http\Resources\MembersResource;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    /**
     * @param MembersRequest
     * @return MembersResource
     */
    public function index(MembersRequest $request)
    {
        $eventIds = $request->get('eventIds', []);
        $members = Member::inEvent($eventIds)
            ->simplePaginate(15);
        return new MembersResource($members);
    }

    /**
     * @param int $id
     * @return MemberResource
     */
    public function show($id)
    {
        $member = Member::find($id);
        if (empty($member)) {
            return response()->json([
                'status_code'  => 200,
                'message'      => 'Member does not exist',
            ], 200);
        }
        return new MemberResource($member);
    }

    /**
     * @param CreateMemberRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateMemberRequest $request)
    {
        $eventIds = $request->get('eventIds');
        $memberName = $request->get('name');
        $memberSurname = $request->get('surname');
        $memberEmail = $request->get('email');
        $member = new Member();
        $member->name = $memberName;
        $member->surname = $memberSurname;
        $member->email = $memberEmail;
        DB::beginTransaction();
        try {
            $member->save();
            $member->events()->attach($eventIds);
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json([
                'status_code'  => 500,
                'message'      => 'Error: ' . $e->getMessage(),
            ], 500);
        }
        DB::commit();
        event(new AfterCreateMember($member));
        return response()->json([
            'status_code'  => 200,
            'message'      => 'User created successfully',
        ], 200);
    }

    /**
     * @param UpdateMemberRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateMemberRequest $request, $id)
    {
        $member = Member::find($id);
        if (empty($member)) {
            return response()->json([
                'status_code'  => 500,
                'message'      => 'Member does not exist',
            ], 500);
        }
        $eventIds = $request->get('eventIds');
        $memberName = $request->get('name');
        $memberSurname = $request->get('surname');
        $memberEmail = $request->get('email');
        $member->name = $memberName;
        $member->surname = $memberSurname;
        $member->email = $memberEmail;
        DB::beginTransaction();
        try {
            $member->save();
            $member->events()->sync($eventIds);
        } catch(\Exception $e) {
            DB::rollback();
            return response()->json([
                'status_code'  => 500,
                'message'      => 'Error: ' . $e->getMessage(),
            ], 500);
        }
        DB::commit();
        return response()->json([
            'status_code'  => 200,
            'message'      => 'User updated successfully',
        ], 200);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $member = Member::find($id);
        if (empty($member)) {
            return response()->json([
                'status_code'  => 200,
                'message'      => 'Member does not exist',
            ], 200);
        }
        if ($member->delete()) {
            return response()->json([
                'status_code'  => 200,
                'message'      => 'Member successfully deleted',
            ], 200);
        }
        return response()->json([
            'status_code'  => 200,
            'message'      => 'Member not deleted',
        ], 200);
    }
}
