<?php 
/** 
 * Answer view
 *
 * Partisk : Political Party Opinion Visualizer
 * Copyright (c) Partisk.nu Team (https://www.partisk.nu)
 *
 * Partisk is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Partisk is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Partisk. If not, see http://www.gnu.org/licenses/.
 *
 * @copyright   Copyright (c) Partisk.nu Team (https://www.partisk.nu)
 * @link        https://www.partisk.nu
 * @package     app.View.Elements
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

$answerHtml = null;
$answerClass = null;

$answerHtml = $this->Html->link($answer['answer'],
      array('controller' => 'answers', 'action' => 'view', $answer['id']));

if($answer['answer'] == "ja") { $answerClass = 'class="yes"'; } 
if($answer['answer'] == "nej") { $answerClass = 'class="no"'; } ?>
<td <?php echo $answerClass ?>>
  <?php 
    echo  $answerHtml;
  ?>
</td>