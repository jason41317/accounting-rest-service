<?php

namespace App\Http\Controllers;

use App\Http\Resources\JournalEntryResource;
use App\Models\JournalEntry;
use App\Services\JournalEntryService;
use Illuminate\Http\Request;

class JournalEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $journalEntryService = new JournalEntryService();
        $perPage = $request->per_page ?? 20;
        $isPaginated = !$request->has('paginate') || $request->paginate === 'true';
        $journalEntries = $journalEntryService->list($isPaginated, $perPage);
        return JournalEntryResource::collection(
            $journalEntries
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $journalEntryService = new JournalEntryService();
        $data = $request->except('account_titles');
        $accountTitles = $request->accountTitles;
        $journalEntry = $journalEntryService->store($data, $accountTitles);
        return (new JournalEntryResource($journalEntry))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JournalEntry  $journalEntry
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $journalEntryService = new JournalEntryService();
        $journalEntry = $journalEntryService->get($id);
        return new JournalEntryResource($journalEntry);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JournalEntry  $journalEntry
     * @return \Illuminate\Http\Response
     */
    public function edit(JournalEntry $journalEntry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JournalEntry  $journalEntry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $journalEntryService = new JournalEntryService();
        $data = $request->except('account_titles');
        $accountTitles = $request->accountTitles;
        $journalEntry = $journalEntryService->update($data, $accountTitles, $id);

        return (new JournalEntryResource($journalEntry))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JournalEntry  $journalEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $journalEntryService = new JournalEntryService();
        $journalEntryService->delete($id);
        return response()->json([], 204);
    }
}
