<?php
/**
 * Question template.
 *
 * @since 3.0.0
 */

learn_press_admin_view( 'quiz/answers' );
learn_press_admin_view( 'quiz/settings' );
?>

<script type="text/x-template" id="tmpl-lp-quiz-question-item">
    <tr class="question-item">
        <td class="lp-column-sort"><i class="fa fa-bars"></i></td>
        <td class="lp-column-order"></td>
        <td class="lp-column-name">
            <input type="text" class="question-title lp-question-heading-title"
                   v-model="question.title"
                   @keyup.enter='updateTitle'
                   @blur="updateTitle"
                   @input="onChangeTitle">
        </td>
        <td class="lp-column-type">{{question.type}}</td>
        <td class="lp-column-actions">
            <div class="lp-box-data-actions lp-toolbar-buttons">
                <div class="lp-toolbar-btn lp-toolbar-btn-dropdown lp-btn-change-type">
                    <a data-tooltip="Change type of this question"
                       class="lp-btn-icon dashicons dashicons-editor-help"></a>
                    <ul>
                        <li v-for="(type, key) in questionTypes" :data-type="key"
                            :class="isAcitve(type) ? 'active' : ''">
                            <a href="">{{type}}</a>
                        </li>
                    </ul>
                </div>
                <div class="lp-toolbar-btn">
                    <a target="_blank" data-tooltip="Edit question in new window" :href="urlEdit"
                       class="lp-btn-icon dashicons dashicons-admin-links learn-press-tooltip"></a>
                </div>
                <div class="lp-toolbar-btn">
                    <a target="_blank" data-tooltip="Clone this question"
                       class="lp-btn-icon dashicons dashicons-admin-page learn-press-tooltip"></a>
                </div>
                <div class="lp-toolbar-btn lp-btn-remove lp-toolbar-btn-dropdown">
                    <a data-tooltip="Remove this question"
                       class="lp-btn-icon dashicons dashicons-trash learn-press-tooltip"></a>
                    <ul>
                        <li><a class="learn-press-tooltip" data-tooltip="" data-delete-permanently="yes"> Delete
                                permanently </a>
                        </li>
                    </ul>
                </div>
                <span @click="toggle" :class="question.open ?'open' : 'close'"
                      class="lp-toolbar-btn lp-btn-toggle learn-press-tooltip"
                      data-tooltip="Toggle question content"></span>
            </div>
        </td>
    </tr>
</script>

<script>

    (function (Vue, $store) {

        Vue.component('lp-quiz-question-item', {
            template: '#tmpl-lp-quiz-question-item',
            props: ['question', 'questionTypes'],
            data: function () {
                return {
                    unsaved: false,
                    removing: false
                };
            },
            computed: {
                urlEdit: function () {
                    return 'post.php?post=' + this.question.id + '&action=edit';
                }
            },
            methods: {
                toggle: function () {
                    $store.dispatch('lqs/toggleQuestion', this.question);
                },
                isAcitve: function (type) {
                    return this.questionType === type;
                },
                onChangeTitle: function () {
                    this.unsaved = true;
                },
                updateTitle: function () {
                    this.update();
                },
                update: function () {
                    this.unsaved = false;
                    $store.dispatch('lqs/updateQuestion', this.question);
                }
            }
        });

    })(Vue, LP_Quiz_Store);

</script>
