/*
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS HEADER.
 *
 * Copyright 2011 Oracle and/or its affiliates. All rights reserved.
 *
 * Oracle and Java are registered trademarks of Oracle and/or its affiliates.
 * Other names may be trademarks of their respective owners.
 *
 * The contents of this file are subject to the terms of either the GNU
 * General Public License Version 2 only ("GPL") or the Common
 * Development and Distribution License("CDDL") (collectively, the
 * "License"). You may not use this file except in compliance with the
 * License. You can obtain a copy of the License at
 * http://www.netbeans.org/cddl-gplv2.html
 * or nbbuild/licenses/CDDL-GPL-2-CP. See the License for the
 * specific language governing permissions and limitations under the
 * License.  When distributing the software, include this License Header
 * Notice in each file and include the License file at
 * nbbuild/licenses/CDDL-GPL-2-CP.  Oracle designates this
 * particular file as subject to the "Classpath" exception as provided
 * by Oracle in the GPL Version 2 section of the License file that
 * accompanied this code. If applicable, add the following below the
 * License Header, with the fields enclosed by brackets [] replaced by
 * your own identifying information:
 * "Portions Copyrighted [year] [name of copyright owner]"
 *
 * If you wish your version of this file to be governed by only the CDDL
 * or only the GPL Version 2, indicate your decision by adding
 * "[Contributor] elects to include this software in this distribution
 * under the [CDDL or GPL Version 2] license." If you do not indicate a
 * single choice of license, a recipient has the option to distribute
 * your version of this file under either the CDDL, the GPL Version 2 or
 * to extend the choice of license to its licensees as provided above.
 * However, if you add GPL Version 2 code and therefore, elected the GPL
 * Version 2 license, then the option applies only if the new code is
 * made subject to such option by the copyright holder.
 *
 * Contributor(s):
 *
 * Portions Copyrighted 2011 Sun Microsystems, Inc.
 */

$(document).ready(function() {
    var $lastClicked;
    initDatepicker();
    initFlashes();
    initErrorFields();
    initChangeStatusDialog();
    initDeleteDialog();
    initDeleteMSDialog();
    initOpenMSDialog();
    initCompleteMilestoneDialog();
    jQuery(".chzn-select").chosen();
    $('#dataTable').dataTable( {
		"bJQueryUI": true
    });
});

function initDatepicker() {
    $('.datepicker')
        .attr('readonly', 'readonly')
        .datepicker({
            dateFormat: 'yy-mm-dd'
        });
}

function initFlashes() {
    var flashes = $("#flashes");
    if (!flashes.length) {
        return;
    }
    setTimeout(function() {
        flashes.slideUp("slow");
    }, 2000);
}

function initErrorFields() {
    $('.error-field').first().focus();
}

function initDeleteDialog() {
    var deleteDialog = $('#delete-dialog');
    var deleteLink = $('#delete-link');
    deleteDialog.dialog({
        autoOpen: false,
        modal: true,
        width: 476,
        buttons: {
            'OK': function() {
                $(this).dialog('close');
                location.href = deleteLink.attr('href');
            },
            'Cancel': function() {
                $(this).dialog('close');
            }
        }
    });
    deleteLink.click(function() {
        deleteDialog.dialog('open');
        return false;
    });
}

function initDeleteMSDialog() {
    var deleteMsDialog = $('#delete-ms-dialog');
    var deleteMsLink = $('.delete-ms');
    deleteMsDialog.dialog({
        autoOpen: false,
        modal: true,
        width: 476,
        buttons: {
            'OK': function() {
                $(this).dialog('close');
                location.href = $lastClicked.attr('href');
            },
            'Cancel': function() {
                $(this).dialog('close');
            }
        }
    });
    deleteMsLink.click(function() {
	 $lastClicked = $(this);
        deleteMsDialog.dialog('open');
        return false;
    });
}

function initOpenMSDialog() {
    var openMsDialog = $('#open-ms-dialog');
    var openMsLink = $('.open-ms-link');
    openMsDialog.dialog({
        autoOpen: false,
        modal: true,
        width: 476,
        buttons: {
            'OK': function() {
                $(this).dialog('close');
                location.href = $lastClicked.attr('href');
            },
            'Cancel': function() {
                $(this).dialog('close');
            }
        }
    });
    openMsLink.click(function() {
        $lastClicked = $(this);
        openMsDialog.dialog('open');
        return false;
    });
}

function initChangeStatusDialog() {
    var changeStatusDialog = $('#change-status-dialog');
    var changeStatusLink = $('.change-status-link');
    var changeStatusForm = $('#change-status-form');
    changeStatusDialog.dialog({
        autoOpen: false,
        modal: true,
        width: 476,
        buttons: {
            'OK': function() {
                changeStatusForm.submit();
                $(this).dialog('close');
            },
            'Cancel': function() {
                $(this).dialog('close');
            }
        }
    });
    changeStatusLink.click(function() {
        changeStatusForm.attr('action', $(this).attr('href'));
        changeStatusDialog.dialog('option', 'title', $(this).attr('title'));
        changeStatusDialog.dialog('open');
        return false;
    });
}

function initCompleteMilestoneDialog() {
    var completeMilestoneDialog = $('#complete-milestone-dialog');
    var completeMilestoneLink = $('.complete-milestone-link');
    var completeMilestoneForm = $('#complete-milestone-form');
    completeMilestoneDialog.dialog({
        autoOpen: false,
        modal: true,
        width: 476,
        buttons: {
            'OK': function() {
		  location.href = $lastClicked.attr('href');
		  completeMilestoneForm.submit();
                $(this).dialog('close');
            },
            'Cancel': function() {
                $(this).dialog('close');
            }
        }
    });
    completeMilestoneLink.click(function() {
        $lastClicked = $(this);
	 completeMilestoneForm.attr('action', $(this).attr('href'));
        completeMilestoneDialog.dialog('open');
        return false;
    });
}
