INSERT INTO marker_category (name, description) VALUES ('Shot', 'A series of frames that run for an uninterrupted period of time');

INSERT INTO marker_category (name, description) VALUES ('Credits', 'This should be fairly straightforward, unless the credits are rhythmically presented in some complicating fashion that requires you to make a choice about how to mark.');

INSERT INTO marker_category (name, description) VALUES ('Beat', 'A beat is a notable punctuation mark significant to the unfolding of the film, most typically the story of the film. It is largely an element you feel. Even though various screenwriting manuals define it in differently—as every action that generates a reaction, as coterminous with a scene, as a significant pause in the dialogue—we will define a beat as a punctuation mark ');

INSERT INTO marker_category (name, description) VALUES ('Scene', 'Often organized around an event of some scale from small to large, a scene constitutes a contiguous action in space and time. Complicating elements here might entail, say, cross-cutting between two spaces, which may imply a larger spatial contiguity (a telephone conversation, for example), or may suggest the scene is either split into two scenes—or dissolves the scene as a unit of narrative meaning altogether—or possesses a complicated relationship to space and even time. ');

INSERT INTO marker_category (name, description) VALUES ('Sequence', 'A series of scenes that hold together as a unit of narrative meaning beyond the individual scene, but not as large scale as an act.');

INSERT INTO marker_category (name, description) VALUES ('Act', 'A series of scenes and sequences that typically culminates in some significant shift in the plot and/or tone (depending on the mode of the film), turning the narrative and/or affect in new direction. In much cinema, especially out of Hollywood, that direction is often causally determined, moving from set up to complicating action to development to climax, but some of the films we are watching may not adhere to this causal notion of acts. Moreover, some films may have some sort of prologue, epilogue, or interlude that is not itself an act. Markers are listed for the above below. Should yours deviate in their definitions, please take note of that.');

INSERT INTO marker_category (name, description) VALUES ('Turning points', 'Significant or notable turn occurs in the story of the film, or perhaps in the film on some other level that you note down and define. We are not looking for every micro development, but when significant or notable turning points. Take some notes on this matter so you can say how you thought about this.');

INSERT INTO marker_category (name, description) VALUES ('Plot', 'Define major and minor plots within the film');

INSERT INTO marker_category (name, description) VALUES ('Time', '');

INSERT INTO marker_category (name, description) VALUES ('Transition', '');

INSERT INTO marker_category (name, description) VALUES ('Space', '');

INSERT INTO marker_category (name, description) VALUES ('Characters', '');

INSERT INTO marker_category (name, description) VALUES ('Top Level', '');

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Shot', '' FROM marker_category
WHERE name = 'Shot';


-- Credits

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Opening Credits Start', '' FROM marker_category
WHERE name = 'Credits';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Opening Credits Stop', '' FROM marker_category
WHERE name = 'Credits';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Closing Credits Start', '' FROM marker_category
WHERE name = 'Credits';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Closing Credits Stop', '' FROM marker_category
WHERE name = 'Credits';


-- Beat

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Emotion', 'A moment in which an emotion notably punctuates the unfolding of the film' FROM marker_category
WHERE name = 'Beat';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Revelation', 'A moment in which an action—information is revealed, a discovery occurs, a decision is made— notably punctuates the unfolding of the film.' FROM marker_category
WHERE name = 'Beat';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Event', 'A moment in which an event—someone dies, a car explodes, an important object is obtained— notably punctuates the unfolding of the film.' FROM marker_category
WHERE name = 'Beat';

-- Scene

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Scene', '' FROM marker_category
WHERE name = 'Scene';

-- Sequence

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Sequence', '' FROM marker_category
WHERE name = 'Sequence';

-- Act

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Act 1 (set up) begins', '' FROM marker_category
WHERE name = 'Act';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Act 1 (set up) ends', '' FROM marker_category
WHERE name = 'Act';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Act 2 (complicating action) begins', '' FROM marker_category
WHERE name = 'Act';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Act 2 (complicating action) ends', '' FROM marker_category
WHERE name = 'Act';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Act 3 (development) begins', '' FROM marker_category
WHERE name = 'Act';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Act 3 (development) ends', '' FROM marker_category
WHERE name = 'Act';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Act 4 (climax) begins', '' FROM marker_category
WHERE name = 'Act';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Act 4 (climax) ends', '' FROM marker_category
WHERE name = 'Act';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Prologue', '' FROM marker_category
WHERE name = 'Act';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Epilogue', '' FROM marker_category
WHERE name = 'Act';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Interlude', '' FROM marker_category
WHERE name = 'Act';


-- Turning Points

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Turning Point', '' FROM marker_category
WHERE name = 'Turning Points';

-- Plot

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Plot', '' FROM marker_category
WHERE name = 'Plot';

-- Time

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Diegetic Time (Quantitative)', 'Note any references to/indications of diegetic time that are exact (or quantitative) a clock, a year, a date, and so on. 9A = references to dates, so, for example, 9A-00/00/1975 or 9A-09/11/2001. 9B = references to times of day, so, for example, 9B-10:32AM' FROM marker_category
WHERE name = 'Time';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Diegetic Time (Qualitative)', 'Note any indications of/references to diegetic time that are inexact (or qualitative). We will supply a list of qualitative time markers separately for you to use, but, for example, it might be 10-past-winter' FROM marker_category
WHERE name = 'Time';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Discursive Time: Linear', 'Many films unfold with a linear relationship to time. Event 1 leads to Event 2, which are chronologically interrelated. This will probably be the most common form of temporal movement.' FROM marker_category
WHERE name = 'Time';


INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Discursive Time: Simultaneous', 'Simultaneous time is also very common, engendering a sense of “meanwhile time” (as Benedict Anderson calls it). So two scenes may effectively unfold at the same time rather than in linear sequence, or within a scene, cross-cutting between two spaces may assert simultaneity. ' FROM marker_category
WHERE name = 'Time';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Discursive Time: Analeptic', 'An analepsis is a movement backwards in time from the linear unfolding of time in the film. Memento, for example, mixes linear and analeptic time, while The Godfather Part II contains two linear timelines, one of which, however, is an analepsis in relation to the other, this it would be marked as both linear and analeptic. Back to the Future is another possible example: is it purely linear, or is it bluntly analeptic and linear, with little playing with time within the acts themselves?' FROM marker_category
WHERE name = 'Time';


INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Discursive Time: Proleptic', 'A prolepsis is a movement forwards in time that jumps ahead of the linear progression of time. Thus when Marty goes “back to the future” at the end of that film, we might see this as a prolepsis.' FROM marker_category
WHERE name = 'Time';


-- Transitions

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Shot Transition: Spatial', 'Take note if when a shot changes, there is a notable change of space. Keep notes on how you are tracking this.' FROM marker_category
WHERE name = 'Transition';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Shot Transition: Temporal', 'Take note if when a shot changes, there is a notable change of time. Keep notes on how you are tracking this.' FROM marker_category
WHERE name = 'Transition';


INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Shot Transition: Spatial-Temporal', 'Take note if when a shot changes, there is a notable change of time and space. Keep notes on how you are tracking this.' FROM marker_category
WHERE name = 'Transition';


INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Scene Transition: Spatial', 'Take note if when a shot changes, there is a notable change of space. Keep notes on how you are tracking this.' FROM marker_category
WHERE name = 'Transition';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Scene Transition: Temporal', 'Take note if when a shot changes, there is a notable change of time. Keep notes on how you are tracking this.' FROM marker_category
WHERE name = 'Transition';

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Scene Transition: Spatial-Temporal', 'Take note if when a shot changes, there is a notable change of time and space. Keep notes on how you are tracking this.' FROM marker_category
WHERE name = 'Transition';



-- Space

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Space', '' FROM marker_category
WHERE name = 'Space';


-- Characters

INSERT INTO marker_type (marker_category_id, name, description)
SELECT id, 'Characters', '' FROM marker_category
WHERE name = 'Characters';

-- Films

INSERT INTO film (film_name, film_url) VALUES ('Before Sunrise', 'videos/BeforeSunrise.webm');
INSERT INTO film (film_name, film_url) VALUES ('Before Sunset', 'videos/BeforeSunset.webm');
INSERT INTO film (film_name, film_url) VALUES ('Before Midnight', 'videos/BeforeMidnight.webm');
INSERT INTO film (film_name, film_url) VALUES ('Boyhood', 'videos/Boyhood.webm');
INSERT INTO film (film_name, film_url) VALUES ('Big Buck Bunny', 'videos/big-buck-bunny_trailer.webm');
