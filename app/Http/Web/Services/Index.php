<?php

namespace App\Http\Web\Services;

use App\Caches\IndexFreeCourseList as IndexFreeCourseListCache;
use App\Caches\IndexLiveList as IndexLiveListCache;
use App\Caches\IndexNewCourseList as IndexNewCourseListCache;
use App\Caches\IndexSlideList as IndexSlideListCache;
use App\Caches\IndexVipCourseList as IndexVipCourseListCache;
use App\Models\Slide as SlideModel;

class Index extends Service
{

    public function getSlides()
    {
        $cache = new IndexSlideListCache();

        /**
         * @var array $slides
         */
        $slides = $cache->get();

        if (!$slides) return [];

        foreach ($slides as $key => $slide) {

            $slides[$key]['style'] = SlideModel::htmlStyle($slide['style']);

            switch ($slide['target']) {
                case SlideModel::TARGET_COURSE:
                    $slides[$key]['url'] = $this->url->get([
                        'for' => 'web.course.show',
                        'id' => $slide['content'],
                    ]);
                    break;
                case SlideModel::TARGET_PAGE:
                    $slides[$key]['url'] = $this->url->get([
                        'for' => 'web.page.show',
                        'id' => $slide['content'],
                    ]);
                    break;
                case SlideModel::TARGET_LINK:
                    $slides[$key]['url'] = $slide['content'];
                    break;
                default:
                    break;
            }
        }

        return $slides;
    }

    public function getLives()
    {
        $cache = new IndexLiveListCache();

        return $cache->get();
    }

    public function getNewCourses()
    {
        $cache = new IndexNewCourseListCache();

        $courses = $cache->get();

        return $this->handleCategoryCourses($courses);
    }

    public function getFreeCourses()
    {
        $cache = new IndexFreeCourseListCache();

        $courses = $cache->get();

        return $this->handleCategoryCourses($courses);
    }

    public function getVipCourses()
    {
        $cache = new IndexVipCourseListCache();

        $courses = $cache->get();

        return $this->handleCategoryCourses($courses);
    }

    protected function handleCategoryCourses($items, $limit = 8)
    {
        if (count($items) == 0) {
            return [];
        }

        foreach ($items as &$item) {
            $item['courses'] = array_slice($item['courses'], 0, $limit);
        }

        return $items;
    }

}