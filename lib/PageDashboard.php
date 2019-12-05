<?php
/**
 * COPS (Calibre OPDS PHP Server) class file
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Jernej Zorec <jernejz@gmail.com>
 */

class PageDashboard extends Page
{
    public function InitializeContent ()
    {
        $this->title = localize ("dashboard.title");

        $popularTagId = Tag::getTagByName('Popular');
        $popular = Book::getBooksByTag(43, 10)[0];
        foreach ($popular as &$entry) {
            $entry->book->group = "POPULAR";
        }

        $tags = Tag::getAllTags();
        $popularCopsId = "cops:tags:".$popularTagId->id;
        foreach ($tags as $key => &$entry) {
            if($entry->id == $popularCopsId) {
                unset($tags[$key]);
                continue;
            }
            $entry->group = "TAGS";
        }

        $recentBooks = Book::getAllRecentBooks();
        foreach ($recentBooks as &$entry) {
            $entry->book->group = "RECENTS";
        }
        $allAuthors = Author::getAllAuthors();
        foreach ($allAuthors as &$entry) {
            $entry->group = "AUTHORS";
        }

        $this->entryArray = array_merge($tags, $popular, $recentBooks, $allAuthors);

        //$this->entryArray = $allAuthors;
        //var_dump($this->entryArray);

        $this->idPage = "cops:dashboard";
    }
}
