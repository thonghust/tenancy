<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWebsiteRequest;
use App\Http\Requests\UpdateWebsiteRequest;
use App\Repositories\WebsiteRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class WebsiteController extends AppBaseController
{
    /** @var  WebsiteRepository */
    private $websiteRepository;

    public function __construct(WebsiteRepository $websiteRepo)
    {
        $this->websiteRepository = $websiteRepo;
    }

    /**
     * Display a listing of the Website.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->websiteRepository->pushCriteria(new RequestCriteria($request));
        $websites = $this->websiteRepository->all();

        return view('websites.index')
            ->with('websites', $websites);
    }

    /**
     * Show the form for creating a new Website.
     *
     * @return Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created Website in storage.
     *
     * @param CreateWebsiteRequest $request
     *
     * @return Response
     */
    public function store(CreateWebsiteRequest $request)
    {
        $input = $request->all();

        $website = $this->websiteRepository->create($input);

        Flash::success('Website saved successfully.');

        return redirect(route('websites.index'));
    }

    /**
     * Display the specified Website.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $website = $this->websiteRepository->findWithoutFail($id);

        if (empty($website)) {
            Flash::error('Website not found');

            return redirect(route('websites.index'));
        }

        return view('websites.show')->with('website', $website);
    }

    /**
     * Show the form for editing the specified Website.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $website = $this->websiteRepository->findWithoutFail($id);

        if (empty($website)) {
            Flash::error('Website not found');

            return redirect(route('websites.index'));
        }

        return view('websites.edit')->with('website', $website);
    }

    /**
     * Update the specified Website in storage.
     *
     * @param  int              $id
     * @param UpdateWebsiteRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWebsiteRequest $request)
    {
        $website = $this->websiteRepository->findWithoutFail($id);

        if (empty($website)) {
            Flash::error('Website not found');

            return redirect(route('websites.index'));
        }

        $website = $this->websiteRepository->update($request->all(), $id);

        Flash::success('Website updated successfully.');

        return redirect(route('websites.index'));
    }

    /**
     * Remove the specified Website from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $website = $this->websiteRepository->findWithoutFail($id);

        if (empty($website)) {
            Flash::error('Website not found');

            return redirect(route('websites.index'));
        }

        $this->websiteRepository->delete($id);

        Flash::success('Website deleted successfully.');

        return redirect(route('websites.index'));
    }
}
